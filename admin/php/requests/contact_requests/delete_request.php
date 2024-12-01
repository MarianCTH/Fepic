<?php
$log_file = "../../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
} 

if (isset($_POST['userId']) && is_numeric($_POST['userId'])) {
    require_once '../../../../config/config.php';
    $userId = $_POST['userId'];

    $sql = "DELETE FROM cereri_contact WHERE ID_cerere = ?";
    $stmt = $db->prepare($sql);


    if (!$stmt) {
        die("ERROR: Prepare failed");
    }

    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $db->close();
}
?>