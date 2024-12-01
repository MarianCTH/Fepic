<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();

include_once("../../config/config.php");
header("Content-type: text/html; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Acest format nu este permis. Textul trebuie să fie un email!";
    } else {
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            $userEmail = $_SESSION["email"];
            
            if ($userEmail === $email) {
                $subscribedCheckStmt = $db->prepare("SELECT ID FROM subscription WHERE email = ?");
                $subscribedCheckStmt->bind_param('s', $email);
                $subscribedCheckStmt->execute();
                $subscribedCheckResult = $subscribedCheckStmt->get_result();

                if ($subscribedCheckResult->num_rows > 0) {
                    echo "Acest email este deja abonat.";
                } else {
                    $insertStmt = $db->prepare("INSERT INTO subscription (email) VALUES (?)");
                    $insertStmt->bind_param('s', $email);

                    if ($insertStmt->execute()) {
                        echo "Felicitări! V-ați abonat cu succes!";
                    } else {
                        echo "Error: " . $insertStmt->error;
                    }

                    $insertStmt->close();
                }

                $subscribedCheckStmt->close();
            } else {
                echo "Nu aveți permisiunea să abonați alt email decât cel al utilizatorului curent.";
            }
        } else {
            $subscribedCheckStmt = $db->prepare("SELECT ID FROM subscription WHERE email = ?");
            $subscribedCheckStmt->bind_param('s', $email);
            $subscribedCheckStmt->execute();
            $subscribedCheckResult = $subscribedCheckStmt->get_result();

            if ($subscribedCheckResult->num_rows > 0) {
                echo "Acest email este deja abonat.";
            } else {
                $insertStmt = $db->prepare("INSERT INTO subscription (email) VALUES (?)");
                $insertStmt->bind_param('s', $email);

                if ($insertStmt->execute()) {
                    echo "Felicitări! V-ați abonat cu succes!";
                } else {
                    echo "Error: " . $insertStmt->error;
                }

                $insertStmt->close();
            }

            $subscribedCheckStmt->close();
        }
    }

    $db->close();
}
?>
