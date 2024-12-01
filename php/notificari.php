<?php

function sendNotification($role, $message, $type)
{
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($db === false){
        die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
    }

    $sql = "INSERT INTO notifications (role, message, type) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('sss', $role, $message, $type);
    $stmt->execute();

    $stmt->close();
    $db->close();
}

function getNotifications($role)
{
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($db === false) {
        die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM notifications WHERE role = ? ORDER BY id DESC";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $role);
    $stmt->execute();

    $result = $stmt->get_result();
    $notifications = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $db->close();

    return $notifications;
}

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

?>