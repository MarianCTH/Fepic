<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../../config/config.php';

    $subscriberQuery = "SELECT COUNT(*) as count FROM subscription";
    $subscriberResult = $db->query($subscriberQuery);
    $subscribers = ($subscriberResult) ? $subscriberResult->fetch_assoc()['count'] : 0;

    $commentQuery = "SELECT COUNT(*) as count FROM comentarii_postare";
    $commentResult = $db->query($commentQuery);
    $comments = ($commentResult) ? $commentResult->fetch_assoc()['count'] : 0;

    $viewQuery = "SELECT SUM(Vizualizari) as views FROM blog";
    $viewResult = $db->query($viewQuery);
    $views = ($viewResult) ? $viewResult->fetch_assoc()['views'] : 0;

    $likeQuery = "SELECT LikedBy FROM blog";
    $likeResult = $db->query($likeQuery);
    $likes = 0;

    if ($likeResult) {
        while ($row = $likeResult->fetch_assoc()) {
            $likedBy = $row['LikedBy'];
            if (!empty($likedBy)) {
                $likes += count(explode(',', $likedBy)) - 1;
            }
        }

        $likeResult->close();
    }

    if ($subscriberResult) {
        $subscriberResult->close();
    }

    if ($commentResult) {
        $commentResult->close();
    }

    if ($viewResult) {
        $viewResult->close();
    }

    $response = array(
        'success' => true,
        'subscribers' => $subscribers,
        'comments' => $comments,
        'views' => $views,
        'likes' => $likes
    );

    echo json_encode($response);
    $db->close();
}
?>
