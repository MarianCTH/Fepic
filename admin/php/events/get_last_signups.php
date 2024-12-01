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
        es.SIGNUP_DATE,
        CONCAT(u.Nume, ' ', u.Prenume) AS Username,
        u.Poza AS UserPhoto,
        u.TipCont AS AccountType,
        e.Name AS EventName
    FROM
        events_signups AS es
    JOIN
        utilizatori AS u ON es.USER_ID = u.ID
    JOIN
        events AS e ON es.EVENT_ID = e.ID_targ
    ORDER BY
        es.SIGNUP_DATE DESC
";

$result = $db->query($sql);

$events_signups = [];
$stmt = $db->prepare($sql);
$stmt->execute();
$stmt->bind_result($signup_date, $username, $UserPhoto, $AccountType, $event_name);

while ($stmt->fetch()) {
    $events_signups[] = [
        "Username" => $username,
        "UserPhoto" => $UserPhoto,
        "AccountType" => $AccountType,
        "EventName" => $event_name,
        "SIGNUP_DATE" => $signup_date
    ];
}

$response_data = [
    "signup_count" => count($events_signups),
    "events_signups" => $events_signups
];

$stmt->close();
$db->close();

header("Content-Type: application/json");
echo json_encode($response_data);
