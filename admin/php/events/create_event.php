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

$name = mysqli_real_escape_string($db, $_POST['e-title']);
$description = mysqli_real_escape_string($db, $_POST['e-description']);
$articleLink = mysqli_real_escape_string($db, $_POST['e-article-link']);

$startDate = mysqli_real_escape_string($db, $_POST['s-date']);
$startTime = mysqli_real_escape_string($db, $_POST['s-time']);
$startDateTime = convertToDatabaseDateTime($startDate, $startTime);

$endDate = mysqli_real_escape_string($db, $_POST['e-date']);
$endTime = mysqli_real_escape_string($db, $_POST['e-time']);
$endDateTime = convertToDatabaseDateTime($endDate, $endTime);
$uploaded_banner_name = "test"; //$_POST['uploaded-banner-name'];

if (empty($name) || empty($startDate) || empty($startTime) || empty($endDate) || empty($endTime)) {
    $response["success"] = false;
    $response["message"] = "Toate câmpurile marcate cu * sunt obligatorii și trebuie completate.";
} else {
    $stmt = $db->prepare("INSERT INTO events (Name, Description, ArticleLink, Banner, StartDate, EndDate) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssss", $name, $description, $articleLink, $uploaded_banner_name, $startDateTime, $endDateTime);

    if ($stmt->execute()) {
        $response["success"] = true;
        $response["message"] = "Evenimentul a fost adăugat cu succes.";
    } else {
        $response["success"] = false;
        $response["message"] = "Eroare la adăugarea evenimentului: " . $stmt->error;
    }

    $stmt->close();
}

mysqli_close($db);

header('Content-Type: application/json');
echo json_encode($response);