<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();

if (isset($_SESSION["loggedin"])) {
    $postID = $_POST['id'];
    $comment = $_POST['comment'];
    $author = $_SESSION["username"];

    require_once '../../config/config.php';

    $lastCommentTime = isset($_SESSION['lastCommentTime']) ? $_SESSION['lastCommentTime'] : 0;
    $currentTime = time();
    $elapsedTime = $currentTime - $lastCommentTime;

    $delayTime = 60;

    if ($elapsedTime < $delayTime) {
        $remainingTime = $delayTime - $elapsedTime;
        $response = array(
            'success' => false,
            'message' => 'Va rugam asteptati ' . $remainingTime . ' secunde înainte de a posta un alt comentariu.'
        );
    } else {
        $letterCount = strlen($comment);
        if ($letterCount <= 3) {
            $response = array(
                'success' => false,
                'message' => 'Comentariul este prea scurt. Vă rugăm să introduceți un comentariu mai lung.'
            );
        } else {
            $stmt = $db->prepare("INSERT INTO `comentarii_postare` (`ID_postare`, `Autor`, `Comentariu`) 
                                  VALUES (?, ?, ?)");

            $autor_com = $_SESSION["username"];
            $stmt->bind_param("iss", $postID, $autor_com, $comment);

            if ($stmt->execute()) {
                $_SESSION['lastCommentTime'] = $currentTime;
                $updatedTime = "Chiar acum";
                $defaultTimeFormat = "Chiar acum";
                $response = array(
                    'success' => true,
                    'message' => 'Comentariul dumneavoastră a fost postat cu succes.',
                    'author' => $author,
                    'comment' => $comment,
                    'updatedTime' => $defaultTimeFormat,
                    'profilePicture' => $_SESSION["profilePicture"]
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Nu s-a putut posta comentariul. Vă rugăm să încercați din nou.'
                );
            }

            $stmt->close();
            $db->close();

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }

    $db->close();

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    header("Location: ../../sign-in");
    exit();
}
?>
