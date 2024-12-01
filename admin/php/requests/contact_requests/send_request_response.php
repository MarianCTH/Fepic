<?php

$log_file = "../../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

$content = $_POST['content'];

if (empty($content)) {
    http_response_code(400);
    exit("Trebuie să completați textul pentru a trimite răspunsul !");
}
$email_to = $_POST['email_to'];
$email_from = $_POST['email_from'];

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPAuth = true;
require_once '../../../../config/email-config.php';
$mail->setFrom($email, $name);
$mail->addAddress($email_to, $name_to);

$mail->Subject = 'Mesaj nou de la Administrarea Fepic';
$mail->Body = $content;

$mail->send();

?>