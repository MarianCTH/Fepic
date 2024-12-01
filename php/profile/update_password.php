<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
    header("location: ../../index");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['passwordChange'])) {
    require_once '../../config/config.php';
    $userId = $_SESSION['id'];
    include "../../admin/php/logs/log.php";
    $logFile = '../../admin/php/logs/activity.log';

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $conn->set_charset("utf8mb4");
    if ($conn === false) {
        die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
    }

    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    $response = array();

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $response['message'] = '<p class="error-msgg">Te rugăm să completezi toate câmpurile.</p>';
    } elseif ($newPassword !== $confirmPassword) {
        $response['message'] = '<p class="error-msgg">Parolele nu corespund !</p>';
    } else {
        $userId = mysqli_real_escape_string($conn, $userId);

        $query = "SELECT `Parola` FROM `utilizatori` WHERE `ID` = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $currentHashedPassword = $row['Parola'];

        if (password_verify($currentPassword, $currentHashedPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE `utilizatori` SET `Parola` = ? WHERE `ID` = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $userId);
            mysqli_stmt_execute($stmt);

            $response['message'] = '<p class="success-msgg">Parola a fost schimbată cu succes.</p>';
            logMessage('Utilizatorul ' . $_SESSION["username"] . ' ' . $_SESSION["prenume"] . ' [#' . $_SESSION["id"] . '] și-a actualizat parola.');
        } else {
            $response['message'] = '<p class="error-msgg">Parola curentă este greșită.</p>';
        }
    }
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
