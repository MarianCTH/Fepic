<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

include "../../config/config.php";
header("Content-type: text/html; charset=UTF-8");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../../index");
    exit;
}

if (isset($_GET['user_id']) && isset($_GET['key'])) {
    $user_id = $_GET['user_id'];
    $key = $_GET['key'];

    $sql = "SELECT * FROM activare_cont WHERE ID_user = ? AND Keyy = ?";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "is", $user_id, $key);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $remaining_time = $row['Remaining_time'];

            if ($remaining_time > 0) {
                $sql_update = "UPDATE utilizatori SET Status = ? WHERE ID = ?";
                if ($stmt_update = mysqli_prepare($db, $sql_update)) {
                    $status = "Activ";
                    mysqli_stmt_bind_param($stmt_update, "si", $status, $user_id);
                    mysqli_stmt_execute($stmt_update);

                    $sql_delete = "DELETE FROM activare_cont WHERE ID_user = ? AND Keyy = ?";
                    if ($stmt_delete = mysqli_prepare($db, $sql_delete)) {
                        mysqli_stmt_bind_param($stmt_delete, "is", $user_id, $key);
                        mysqli_stmt_execute($stmt_delete);
                    } else {
                        echo 'Oops! Ceva nu a mers bine. Încearcă din nou.';
                    }

                    header("Location: ../../sign-in");
                    exit();
                } else {
                    echo 'Oops! Ceva nu a mers bine. Încearcă din nou.';
                }
            } else {
                echo 'Timpul pentru activarea contului a expirat.';
            }
        } else {
            echo 'Cheia de activare este invalidă.';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo 'Oops! Ceva nu a mers bine. Încearcă din nou.';
    }
} else {
    echo 'Parametrii insuficienți.';
}
?>