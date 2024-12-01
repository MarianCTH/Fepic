<?php
require_once '../../../config/config.php';

function markNotificationAsDeleted($notificationId)
{
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($db === false) {
        die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
    }

    $sql = "DELETE FROM notifications WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $notificationId);
    $stmt->execute();

    $stmt->close();
    $db->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "deleteNotification") {
        $notificationId = $_POST["notificationId"];
        markNotificationAsDeleted($notificationId);
        echo "success";
    }
}

?>
