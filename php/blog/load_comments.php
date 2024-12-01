<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

if (isset($_GET["page"]) && isset($_GET["id"])) {
    include_once("../../config/config.php");
    header("Content-type: text/html; charset=UTF-8");
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $db->set_charset("utf8mb4");

    if ($db === false) {
        die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
    }

    $page = intval($_GET["page"]);
    $id = $_GET["id"];

    $offset = ($page - 1) * 5;

    $stmt = $db->prepare("SELECT * FROM comentarii_postare WHERE ID_postare = ? LIMIT 5 OFFSET ?");
    $stmt->bind_param("si", $id, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $output = "";

    while ($row = $result->fetch_assoc()) {
        $authorcom = $row['Autor'];

        $profilepic2 = "SELECT * FROM utilizatori WHERE Nume = ?";
        $stmtp2 = mysqli_prepare($db, $profilepic2);
        mysqli_stmt_bind_param($stmtp2, 's', $authorcom);
        mysqli_stmt_execute($stmtp2);
        $profilePicture2 = mysqli_stmt_get_result($stmtp2);
        $profilep2 = mysqli_fetch_assoc($profilePicture2);

        $timePosted = strtotime($row['Data']);
        $currentTime = time();
        $elapsedTime = $currentTime - $timePosted;

        if ($elapsedTime >= 86400 * 365) {
            $updatedTime = "Acum " . floor($elapsedTime / (86400 * 365)) . " ani";
        } elseif ($elapsedTime >= 86400) {
            $updatedTime = "Acum " . floor($elapsedTime / 86400) . " zile";
        } elseif ($elapsedTime >= 3600) {
            $updatedTime = "Acum " . floor($elapsedTime / 3600) . " ore";
        } elseif ($elapsedTime >= 60) {
            $updatedTime = "Acum " . floor($elapsedTime / 60) . " minute";
        } elseif ($elapsedTime >= 1) {
            $updatedTime = "Acum " . $elapsedTime . " secunde";
        } else {
            $updatedTime = "Chiar acum";
        }

        $output .= '<li data-aos="fade-up" data-aos-duration="1500">';
        $output .= '<div class="authore_info">';
        $output .= '<div class="avtar">';
        $output .= '<img src="images/profile/' . $profilep2['Poza'] . '" class="comment-author-image" alt="image">';
        $output .= '</div>';
        $output .= '<div class="text">';
        $output .= '<span id="' . $timePosted . '">' . $updatedTime . '</span>';
        $output .= '<h4>' . $row['Autor'] . '</h4>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '<div class="comment">';
        $output .= '<p>' . $row['Comentariu'] . '</p>';
        $output .= '</div>';
        $output .= '</li>';
    }

    echo $output;

    $stmt->close();
}
?>