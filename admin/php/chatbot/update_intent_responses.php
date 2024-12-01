<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $file_path = '../../../js/json/intent_responses.json';
    $intent_responses = json_decode(file_get_contents($file_path), true);

    $intent_responses = array_merge($intent_responses, $data);

    if (file_put_contents($file_path, json_encode($intent_responses))) {
        echo json_encode(['message' => 'Response added successfully']);
    } else {
        echo json_encode(['error' => 'Failed to add response']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    $file_path = '../../../js/json/intent_responses.json';
    $intent_responses = json_decode(file_get_contents($file_path), true);

    $deletedIntent = array_keys($data)[0];
    if (isset($intent_responses[$deletedIntent])) {
        unset($intent_responses[$deletedIntent]);
        if (file_put_contents($file_path, json_encode($intent_responses))) {
            echo json_encode(['message' => 'Response deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete response']);
        }
    } else {
        echo json_encode(['error' => 'Intent not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

?>