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

function convertToDatabaseDateTime($date, $time)
{
    $dateParts = explode('/', $date);
    $formattedDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

    $timeParts = explode(':', trim($time));
    $hour = (int) $timeParts[0];
    $minute = (int) $timeParts[1];

    $formattedTime = sprintf("%02d:%02d:00", $hour, $minute);
    return $formattedDate . ' ' . $formattedTime;
}

$eventID = $_POST['event_id'];
$name = mysqli_real_escape_string($db, $_POST['eventTitleForm']);
$description = mysqli_real_escape_string($db, $_POST['form-description']);
$articleLink = mysqli_real_escape_string($db, $_POST['link-form']);

$startDate = mysqli_real_escape_string($db, $_POST['start-date-form']);
$startTime = mysqli_real_escape_string($db, $_POST['hour-form-start']);
$startDateTime = convertToDatabaseDateTime($startDate, $startTime);

$endDate = mysqli_real_escape_string($db, $_POST['end-date-form']);
$endTime = mysqli_real_escape_string($db, $_POST['hour-form-end']);
$endDateTime = convertToDatabaseDateTime($endDate, $endTime);

$uploaded_banner_name = $_POST['uploaded-banner-name'];

$sql = "UPDATE events SET 
          Name = '$name', 
          Description = '$description', 
          ArticleLink = '$articleLink',
          StartDate = '$startDateTime',
          EndDate = '$endDateTime',
          Banner = '$uploaded_banner_name'
          WHERE ID_targ = $eventID";

if (mysqli_query($db, $sql)) {
    $response = array('success' => true);
}
else {
    $response = array('success' => false, 'error' => mysqli_error($db));
}

mysqli_close($db);

header('Content-Type: application/json');
echo json_encode($response);