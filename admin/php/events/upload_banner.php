<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

if ($_FILES["upload-banner-input"]["error"] === 0) {
    $targetDir = "../../../images/targuri/banner/";
    $fileName = basename($_FILES["upload-banner-input"]["name"]);
    $targetPath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["upload-banner-input"]["tmp_name"], $targetPath)) {
        $response['file_uploaded'] = true;

    } else {
        $response['file_uploaded'] = false;
    }
}