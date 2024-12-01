<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

require '../../PHPMailer/PHPMailerAutoload.php';
include "../../admin/php/log.php";
$logFile = '../../admin/logs/activity.log';
require_once '../notificari.php';

$result = array("message" => "");

require_once '../../config/config.php';
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$db->set_charset("utf8mb4");

if ($db === false) {
    die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $city = $_POST["city"];
    $phone = $_POST["phone"];

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $result["message"] = "Vă rugăm să completați toate câmpurile obligatorii.";
    } else {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPAuth = true;

        require_once '../../config/email-config.php';

        $mail->setFrom($email, $name);
        $mail->addAddress('marianczr7@gmail.com', 'Fepic Support');

        $mail->Subject = $subject;
        $mail->Body = "Nume: $name\n";
        $mail->Body .= "Email: $email\n";
        $mail->Body .= "Mesaj:\n$message\n";
        $mail->Body .= "Oraș: $city\n";
        $mail->Body .= "Telefon: $phone\n";

        if ($mail->send()) {
            $stmt = $db->prepare("INSERT INTO cereri_contact (Nume, Email, Telefon, Oras, Mesaj, Titlu, Status) VALUES (?, ?, ?, ?, ?, ?, 'Nou')");
            $stmt->bind_param("ssssss", $name, $email, $phone, $city, $message, $subject);
            if ($stmt->execute()) {
                $result["message"] = "Mulțumim că ne-ai contactat. O să vă contactăm în curând!";
                sendNotification('Administrator', 'Cerere de contact noua de la <a href="read_request.php?requestId=' . '" class="subject stretched-link text-truncate"style="max-width: 180px;">' . $name . '</a>', 'contact_request');
                logMessage('Cerere de contact noua de la ' . $name . '('.$subject.')');
            } else {
                $result["message"] = "Hopa! Ceva n-a mers bine. Vă rugăm să încercați din nou mai târziu.";
            }
        } else {
            $result["message"] = "Hopa! Ceva n-a mers bine. Vă rugăm să încercați din nou mai târziu.";
        }
    }
}

header('Content-Type: application/json');
echo json_encode($result);
?>
