<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
$response = array();

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

if (isset($_GET['id'])) {
    require_once '../../../config/config.php';

    $event_id = $_GET['id'];
    $sql = "SELECT * FROM events WHERE ID_targ = $event_id";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    require_once '../../../PHPMailer/PHPMailerAutoload.php';

    $sql = "SELECT * FROM subscription";
    $result = $db->query($sql);

    if ($result) {
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->SMTPAuth = true;

        require_once '../../../config/email-config.php';

        $title = 'Eveniment nou ' . $row['Name'];

        $message = "<img src='" . $web_link . "/images/targuri/banner/" . $row['Banner'] . "'>";
        $message .= "\n\nFederatia Patronatelor din Industriile Creative organizează un nou eveniment numit " . $row['Name'];
        $message .= "\nEvenimentul începe la data " . $row['StartDate'] . ' și se termină la ' . $row['EndDate'];
        if (!empty($row['Description'])) {
            $message .= "\n" . $row['Description'];
        }
        if (!empty($row['ArticleLink'])) {
            $message .= "\nPentru mai multe detalii puteți accesa acest articol: <a href='" . $web_link . "/" . $row['ArticleLink'] . "'>" . $web_link . "/" . $row["ArticleLink"] . "</a>";
        }
        $message .= "\n\n";
        $message .= "Participă și tu la evenimentul organizat de Federatia Patronatelor din Industriile Creative (Fepic) apăsând link-ul de mai jos:";
        $message .= "\n<a href='" . $web_link . "/evenimente'>" . $web_link . "/evenimente</a>";

        while ($row = $result->fetch_assoc()) {
            $subscriberEmail = $row["email"];

            $mail->Subject = $title;
            $mail->addAddress($subscriberEmail);

            $mail->Body = $message;

            if (!$mail->send()) {
                $response["error"] = "Mailer Error: " . $mail->ErrorInfo;
                break;
            }

            $mail->clearAddresses();
        }

        $response["success"] = true;
    } else {
        $response["error"] = "Database query error";
    }
    $db->close();

} else {
    $response["error"] = "Event ID not set";
}

header("Content-Type: application/json");
echo json_encode($response);
?>