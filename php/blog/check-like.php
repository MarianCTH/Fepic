<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
require_once '../../config/config.php';

if (isset($_SESSION["loggedin"])) {
    $postId = $_POST['post_id'];
    $userId = $_SESSION['id'];

    $query = "SELECT `LikedBy` FROM `blog` WHERE `Nr_articol` = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $likedBy = explode(',', $row['LikedBy']);

    $response = ['liked' => in_array($userId, $likedBy), 'likes' => count($likedBy)];
}
else{
    $response = ['not_loggedin'];
}
echo json_encode($response);
?>