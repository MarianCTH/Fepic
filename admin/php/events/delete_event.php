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
    $id = $_GET['id'];
    require_once '../../../config/config.php';
    
    $sql = "DELETE FROM events WHERE ID_targ = $id";
    $result = $db->query($sql);
    
    if ($result) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }

    $db->close();
} else {
    $response['success'] = false;
}

header("Content-Type: application/json");
echo json_encode($response);
