<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);
error_log("test");

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

require_once '../../../config/config.php';

$event_id = $_POST['event_id'] ?? null;
$user_id = $_POST['user_id'] ?? null;

if ($event_id === null || $user_id === null) {
    header("HTTP/1.1 400 Bad Request");
    exit();
}

try {
    $stmt = $db->prepare("SELECT Confirmation FROM events_signups WHERE EVENT_ID = ? AND USER_ID = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($currentStatus);
    $stmt->fetch();
    $stmt->close();

    $newStatus = ($currentStatus === 'Confirmat') ? 'în așteptare' : 'Confirmat';

    $stmt = $db->prepare("UPDATE events_signups SET Confirmation = ? WHERE EVENT_ID = ? AND USER_ID = ?");
    $stmt->bind_param("sii", $newStatus, $event_id, $user_id);
    $stmt->execute();
    $success = $stmt->affected_rows > 0;
    $stmt->close();

    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'new_status' => $newStatus]);
} catch (Exception $e) {
    error_log("Error updating status: " . $e->getMessage());
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}
