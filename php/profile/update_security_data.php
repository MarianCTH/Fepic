<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
header("Content-type: application/json; charset=UTF-8");

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
  echo json_encode(array('status' => 'error', 'message' => 'Not logged in'));
  exit;
}

require_once '../../config/config.php';

if ($db === false) {
    echo json_encode(array('status' => 'error', 'message' => 'Database connection error'));
    exit;
}

$value = $_POST['value'];
$userId = $_SESSION["id"];
$inputType = $_POST['inputType'];

$stmt = null;

if ($inputType === 'radioPrivacy') {
    $stmt = $db->prepare("UPDATE date_utilizatori SET Confidentialitate_securitate = ? WHERE ID_utilizator = ?");
} elseif ($inputType === 'dateSecuritate') {
    $stmt = $db->prepare("UPDATE date_utilizatori SET Date_securitate = ? WHERE ID_utilizator = ?");
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
    exit;
}

$stmt->bind_param("ii", $value, $userId);

if ($stmt->execute()) {
    $response = array('status' => 'success', 'message' => 'Value updated successfully');
} else {
    $response = array('status' => 'error', 'message' => 'Failed to update value', 'error' => $stmt->error);
}

error_log($stmt->error, 3, 'error.log');
echo json_encode($response);
?>
