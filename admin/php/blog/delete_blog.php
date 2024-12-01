<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
} 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nr_articol"])) {
    $nr_articol = $_POST["nr_articol"];

    require_once '../../../config/config.php';

    $sql = "DELETE FROM blog WHERE Nr_articol = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $nr_articol);
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $db->close();
}
?>