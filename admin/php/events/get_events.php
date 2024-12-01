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

$sql = "
    SELECT
        Name
    FROM
        events
    ORDER BY
        ID_targ
";

$events = [];
$stmt = $db->prepare($sql);
$stmt->execute();
$stmt->bind_result($event_name);

while ($stmt->fetch()) {
    $events[] = [
        "Name" => $event_name
    ];
}

$stmt->close();
$db->close();

$response_data = [
    "events_count" => count($events),
    "events" => $events
];

header("Content-Type: application/json");
echo json_encode($response_data);
