<?php
$log_file = "../../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once '../../../../config/config.php';

    $recordId = $_POST["userId"];
    $newStatus = 'Deschis';

    $query = "UPDATE cereri_contact SET Status = ? WHERE ID_cerere = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("si", $newStatus, $recordId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "Failed to set record as open"]);
        exit;
    }
}

mysqli_close($db);
?>
