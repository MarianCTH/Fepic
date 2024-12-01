<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
require_once '../../config/config.php';

$sql = "SELECT MIN(`StartDate`) AS UrmatorulTarg, MAX(`EndDate`) AS UltimulTarg FROM `events` WHERE `EndDate` > NOW() ORDER BY `StartDate` ASC LIMIT 1";
$result = $db->query($sql);

$data = array();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentDate = date('Y-m-d H:i:s');

    if ($row['UrmatorulTarg'] > $currentDate) {
        $data['UrmatorulTarg'] = $row['UrmatorulTarg'];
    } else {
        $data['UrmatorulTarg'] = "NotExisting";
    }

    // Find the last event whose end date is in the past
    $sqlLastEvent = "SELECT MAX(`EndDate`) AS UltimulTarg FROM `events` WHERE `EndDate` < NOW()";
    $resultLastEvent = $db->query($sqlLastEvent);

    if ($resultLastEvent->num_rows > 0) {
        $rowLastEvent = $resultLastEvent->fetch_assoc();
        $data['UltimulTarg'] = $rowLastEvent['UltimulTarg'];
    } else {
        $data['UltimulTarg'] = null;
    }
} else {
    $data['UrmatorulTarg'] = null;
    $data['UltimulTarg'] = null;
}

$db->close();

header('Content-Type: application/json');

echo json_encode($data);
?>
