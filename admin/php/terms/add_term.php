<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jsonFile = "../../../js/json/terms_conditions.json";

    $newTermData = json_decode(file_get_contents('php://input'), true);

    $jsonData = file_get_contents($jsonFile);
    $parsedData = json_decode($jsonData, true);
    date_default_timezone_set('UTC');
    $currentDate = date('M j, Y');
    $parsedData["last_updated"] = $currentDate;

    $parsedData["sections"][] = $newTermData;

    date_default_timezone_set('UTC');
    $currentDate = date('M j, Y');
    $parsedData["last_updated"] = $currentDate;

    file_put_contents($jsonFile, json_encode($parsedData, JSON_PRETTY_PRINT));

    http_response_code(200);
    echo json_encode(array("message" => "New term added successfully"));
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
}
