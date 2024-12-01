<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
require_once '../session/2Factor/GoogleAuthenticator.php';
require_once '../../config/config.php';

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
    header("location: ../../index");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateQuery = "UPDATE utilizatori SET 2FactorAuth = 0 WHERE ID = ?";
    $stmt = $db->prepare($updateQuery);
    $stmt->bind_param("i", $userId);
    $userId = $_SESSION['id'];

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $db->close();
}
?>
