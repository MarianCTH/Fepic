<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
    header("location: ../../index");
    exit;
}

$userId = $_SESSION["id"];
if (isset($_GET['action']) && $_GET['action'] === 'delete' && $userId != "") {
    require_once '../../config/config.php';
    require_once '../notificari.php';
    include "../../admin/php/logs/log.php";
    $logFile = '../../admin/php/logs/activity.log';

    $query = "SELECT `nume`, `prenume` FROM `utilizatori` WHERE `ID` = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $param_nume1 = $row['nume'];
    $param_prenume1 = $row['prenume'];

    $delete_query = "DELETE FROM utilizatori WHERE ID = $userId";
    mysqli_query($db, $delete_query);
    $_SESSION = array();
    session_destroy();

    $query = "DELETE FROM `date_utilizatori` WHERE `ID_utilizator` = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $db->close();
    sendNotification('Administrator', 'Utilizatorul <a href="">' . $param_nume1 . ' ' . $param_prenume1 . '</a> a șters contul !', 'delete_acc');
    logMessage('Utilizatorul ' . $param_nume1 . ' ' . $param_prenume1 . ' [#' . $userId . '] a șters contul.');

    $response = array('success' => true);
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
