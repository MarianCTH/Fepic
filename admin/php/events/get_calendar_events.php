<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

require_once '../../../config/config.php';

$sql = "SELECT * FROM events ORDER BY ID_targ";
$result = $db->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = array(
        "title" => $row['Name'],
        "start" => $row['StartDate'],
        "end" => $row['EndDate'],
        "description" => $row['Description'],
        "link" => $row['ArticleLink'],
        "banner" => $row['Banner'],
        "event_id" => $row['ID_targ']
    );
}

$db->close();

header("Content-Type: application/json");
echo json_encode($events);