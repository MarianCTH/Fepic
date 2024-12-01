<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

$account_change = 0;
$blog_post = 0;
$comment_post = 0;
$message = 0;

session_start();
header("Content-type: text/html; charset=UTF-8");
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
    header("location: ../../index");
    exit;
}

require_once '../../config/config.php';

$stmt = $db->prepare("UPDATE setari_notificari SET account_change=?, blog_post=?, comment_post=?, message=? WHERE id_user=?");
$stmt->bind_param("iiiii", $account_change, $blog_post, $comment_post, $message, $id_user);

$id_user = $_SESSION['id'];

$stmt->execute();
$stmt->close();

$db->close();

header("Location: ../../profile");
?>