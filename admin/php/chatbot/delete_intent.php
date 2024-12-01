<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

function deleteIntent($intent, $jsonFilePath)
{
    $intentResponses = json_decode(file_get_contents($jsonFilePath), true);

    if (isset($intentResponses[$intent])) {
        unset($intentResponses[$intent]);

        if (file_put_contents($jsonFilePath, json_encode($intentResponses)) !== false) {
            return true;
        } else {
            error_log("Error writing JSON file: " . $jsonFilePath);
            return false;
        }
    } else {
        return false;
    }
}

if (isset($_POST['intent'])) {
    $intent = $_POST['intent'];
    $jsonFilePath = '../../../js/json/intent_responses.json';

    $result = deleteIntent($intent, $jsonFilePath);

    $response = ['success' => $result];

    header('Content-Type: application/json');
    echo json_encode($response);
    if (!$result) {
        error_log("Failed to delete intent: " . $intent);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Intent parameter not provided']);
    error_log("Intent parameter not provided");
}
?>
