<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

require_once '../../config/config.php';
require_once '../../PHPMailer/PHPMailerAutoload.php';

function generateRandomKey($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $key = '';

    for ($i = 0; $i < $length; $i++) {
        $key .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $key;
}

$email = $_GET['email'];

$sql = "SELECT ID, Nume, Prenume FROM utilizatori WHERE Email = ?";
if ($stmt = mysqli_prepare($db, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $email);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $user_id, $param_nume, $param_prenume);
            mysqli_stmt_fetch($stmt);

            $param_cheie = generateRandomKey();
            $remaining_time = 30;

            $sql4 = "INSERT INTO activare_cont (ID_user, Keyy, Remaining_time) VALUES (?, ?, ?)";
            if ($stmt4 = mysqli_prepare($db, $sql4)) {
                mysqli_stmt_bind_param($stmt4, "isi", $user_id, $param_cheie, $remaining_time);
                mysqli_stmt_execute($stmt4);
                mysqli_stmt_close($stmt4);
                $activationLink = 'https://'. $web_link .'/php/activate_account.php?user_id=' . $user_id . '&key=' . $param_cheie;

                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                require_once '../../config/email-config.php';
                $mail->addAddress($email, $param_nume . ' ' . $param_prenume);
                $mail->Subject = 'Activare Cont';
                $mail->Body = 'Te rugăm să dai click pe următorul link pentru a-ți activa contul: ' . $activationLink;

                if ($mail->send()) {
                    echo '<p class="success">Email-ul de verificare a fost trimis cu succes.</p>';
                } else {
                    echo '<p class="error">Oops! Ceva nu a mers bine. Încearcă din nou mai târziu.</p>';
                }
            } else {
                echo '<p class="error">Oops! Ceva nu a mers bine. Încearcă din nou.</p>';
            }
        } else {
            echo '<p class="error">Nu există un utilizator asociat cu adresa de email specificată.</p>';
        }
    } else {
        echo '<p class="error">Oops! Ceva nu a mers bine. Încercați din nou mai târziu.</p>';
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($db);
?>
