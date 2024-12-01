<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    require_once '../../config/config.php';
    $userID = $_SESSION["id"];
    $eventID = $_GET['eventID'];

    $getFileNameQuery = "SELECT UPLOADED_DOCUMENT FROM events_signups WHERE USER_ID = ? AND EVENT_ID = ?";
    $getFileNameStmt = $db->prepare($getFileNameQuery);
    $getFileNameStmt->bind_param('ii', $userID, $eventID);
    $getFileNameStmt->execute();
    $getFileNameStmt->bind_result($uploadedDocument);
    $getFileNameStmt->fetch();
    $getFileNameStmt->close();

    $deleteQuery = "DELETE FROM events_signups WHERE USER_ID = ? AND EVENT_ID = ?";
    $deleteStmt = $db->prepare($deleteQuery);
    $deleteStmt->bind_param('ii', $userID, $eventID);
    $deleteStmt->execute();
    $deleteStmt->close();

    $response = ['success' => true, 'message' => 'User registration deleted'];

    if (!empty($uploadedDocument)) {
        $filePath = '../../admin/documents/' . $uploadedDocument;
        if (file_exists($filePath)) {
            unlink($filePath);
            $response['fileDeleted'] = true;
        } else {
            $response['fileDeleted'] = false;
        }
    } else {
        $response['fileDeleted'] = false;
    }
}

echo json_encode($response);
?>
