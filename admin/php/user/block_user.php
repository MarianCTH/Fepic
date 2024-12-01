<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'block' && isset($_GET['user_id'])) {
    require_once '../../../config/config.php';
    require_once '../logs/log.php';
    $logFile = '../logs/activity.log';

    $user_id = $_GET['user_id'];

    $block_query = "UPDATE utilizatori SET status = 'Blocat' WHERE ID = ?";
    $stmt = mysqli_prepare($db, $block_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $rows_affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    logMessage('Contul utilizatorului [#' . $user_id . '] a fost blocat de către administratorul ' . $_SESSION["username"] . ' ' . $_SESSION["prenume"] . ' [#' . $_SESSION["id"] . '].');

    if ($rows_affected > 0) {
        $response = array('status' => 'success', 'message' => 'User blocked successfully');
    } else {
        $response = array('status' => 'error', 'message' => 'User block failed or no changes were made');
    }
    echo json_encode($response);
}