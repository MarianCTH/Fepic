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
require_once '../../../config/config.php';

$sql = "SELECT * FROM subscription";
$result = $db->query($sql);

if ($result) {
    $response["success"] = true;
    $response["number_of_subs"] = $result->num_rows;
} else {
    $response["error"] = "Database query error";
}

$db->close();

header("Content-Type: application/json");
echo json_encode($response);
?>