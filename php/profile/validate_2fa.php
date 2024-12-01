<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

require_once '../session/2Factor/GoogleAuthenticator.php';
require_once '../../config/config.php';

session_start();
header("Content-type: text/html; charset=UTF-8");
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
    header("location: ../../index");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userProvidedCode = $_POST['authenticator_code'];
    $secretKey = $_POST['secret_key'];

    $ga = new PHPGangsta_GoogleAuthenticator();
    if ($ga->verifyCode($secretKey, $userProvidedCode, 2)) {

        $updateQuery = "UPDATE utilizatori SET 2FactorAuth = 1 WHERE ID = ?";
        $stmt = $db->prepare($updateQuery);
        $stmt->bind_param("i", $userId);
        $userId = $_SESSION['id'];

        if ($stmt->execute()) {
            echo 'valid';
        } else {
            echo 'Error updating database: ' . $stmt->error;
        }

        $stmt->close();
        $db->close();
    } else {
        echo 'invalid';
    }
}
?>