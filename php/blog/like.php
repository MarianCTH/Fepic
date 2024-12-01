<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
    header("Location: ../../error");
    exit();
}

require_once '../notificari.php';

require_once '../../config/config.php';
$postId = $_POST['post_id'];
$userId = $_SESSION['id'];
$action = $_POST['action'];

$cooldown = 60;

$lastNotificationTimeKey = "last_notification_time_$postId";
$currentTime = time();
$lastNotificationTime = isset($_SESSION[$lastNotificationTimeKey]) ? $_SESSION[$lastNotificationTimeKey] : 0;

$query = "SELECT `LikedBy` FROM `blog` WHERE `Nr_articol` = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $postId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$likedBy = explode(',', $row['LikedBy']);

if ($action === 'like') {
    if (!in_array($userId, $likedBy)) {
        $likedBy[] = $userId;
        if ($_SESSION['rol'] !== 'Administrator' && ($currentTime - $lastNotificationTime) > $cooldown) {
            sendNotification('Administrator', '<a href="" class="subject stretched-link text-truncate" style="max-width: 180px;">'. $_SESSION['username'] . ' ' . $_SESSION['prenume'] . '</a> a apreciat postarea cu numărul #'. $postId, 'like');
            $_SESSION[$lastNotificationTimeKey] = $currentTime;
        }
    }
} elseif ($action === 'unlike') {
    if (in_array($userId, $likedBy)) {
        $likedBy = array_diff($likedBy, [$userId]);
    }
}

$likedByString = implode(',', $likedBy);

$query = "UPDATE `blog` SET `LikedBy` = ? WHERE `Nr_articol` = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "si", $likedByString, $postId);
$result = mysqli_stmt_execute($stmt);
if ($result === false) {
    error_log("Failed to update liked status for post ID: $postId");
    error_log(mysqli_error($db));
}
mysqli_stmt_close($stmt);

$query = "SELECT `LikedBy` FROM `blog` WHERE `Nr_articol` = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $postId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$likedBy = explode(',', $row['LikedBy']);

$response = ['liked' => in_array($userId, $likedBy), 'likes' => count($likedBy)];
echo json_encode($response);
?>
