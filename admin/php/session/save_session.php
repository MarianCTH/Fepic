<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

require_once '../../../config/config.php';
session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../../error.php");
    exit();
} 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["theme"]) && isset($_POST["navbar_type"])) {
        $_SESSION['theme'] = $_POST["theme"];
        $_SESSION['Navbar_type'] = $_POST["navbar_type"];
    }
}
?>