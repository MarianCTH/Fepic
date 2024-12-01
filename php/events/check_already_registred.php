<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    require_once '../../config/config.php';
    $userID = $_SESSION["id"];
    $eventID = $_GET['eventID'];

    $query = "SELECT Confirmation FROM events_signups WHERE USER_ID = ? AND EVENT_ID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ii', $userID, $eventID);
    $stmt->execute();
    $stmt->bind_result($confirmation);
    $stmt->fetch();

    $stmt->close();

    $response = ['success' => true, 'confirmation' => $confirmation];
    echo json_encode($response);
} else {
    $response = ['success' => false];
    echo json_encode($response);
}
?>
