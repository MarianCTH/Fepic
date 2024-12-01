<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../../error.php");
    exit();
} 
require_once '../../../config/config.php';

// Get today's count
$queryToday = "SELECT COUNT(*) as count, HOUR(DataInregistrarii) as hour FROM utilizatori WHERE DATE(DataInregistrarii) = CURDATE() GROUP BY HOUR(DataInregistrarii)";
$resultToday = $db->query($queryToday);
$dataToday = $resultToday->fetch_all(MYSQLI_ASSOC);

// Get this week's count
$queryWeek = "SELECT COUNT(*) as count, DAYOFWEEK(DataInregistrarii) as day FROM utilizatori WHERE WEEK(DataInregistrarii) = WEEK(NOW()) GROUP BY DAYOFWEEK(DataInregistrarii)";
$resultWeek = $db->query($queryWeek);
$dataWeek = $resultWeek->fetch_all(MYSQLI_ASSOC);

// Get this month's count
$queryMonth = "SELECT COUNT(*) as count, DAY(DataInregistrarii) as day FROM utilizatori WHERE MONTH(DataInregistrarii) = MONTH(NOW()) GROUP BY DAY(DataInregistrarii)";
$resultMonth = $db->query($queryMonth);
$dataMonth = $resultMonth->fetch_all(MYSQLI_ASSOC);

$db->close();

header('Content-Type: application/json');

echo json_encode([
    'today' => array_pad(array_column($dataToday, 'count'), 24, 0),
    'week' => array_pad(array_column($dataWeek, 'count'), 7, 0),
    'month' => array_pad(array_column($dataMonth, 'count'), cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y')), 0),
]);
