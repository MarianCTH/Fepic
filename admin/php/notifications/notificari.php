<?php
$log_file = "../../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

require_once '../config/config.php';
error_log(__DIR__);

function sendNotification($role, $message, $type)
{
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($db === false) {
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
function getTimeAgo($timestamp)
{
    $currentTimestamp = time();
    $timestamp = strtotime($timestamp);
    $timeDiff = $currentTimestamp - $timestamp;

    $minute = 60;
    $hour = 60 * $minute;
    $day = 24 * $hour;
    $week = 7 * $day;
    $month = 30 * $day;
    $year = 365 * $day;

    if ($timeDiff < $minute) {
        return 'Chiar acum';
    } elseif ($timeDiff < $hour) {
        $minutes = floor($timeDiff / $minute);
        if($minutes == 1) return 'Acum un minut';
        return 'Acum ' . $minutes . ' minute';
    } elseif ($timeDiff < $day) {
        $hours = floor($timeDiff / $hour);
        if($hours == 1) return 'Acum o oră';
        else return 'Acum ' . $hours . ' ore';
    } elseif ($timeDiff < $week) {
        $days = floor($timeDiff / $day);
        if($days == 1) return 'Acum o zi';
        else return 'Acum ' . $days . ' zile';
    } elseif ($timeDiff < $month) {
        $weeks = floor($timeDiff / $week);
        if($weeks == 1) return 'Acum o săptămână';
        else return 'Acum ' . $weeks . ' saptamani';
    } elseif ($timeDiff < $year) {
        $months = floor($timeDiff / $month);
        if($months == 1) return 'Acum o lună';
        else return 'Acum ' . $months . ' luni';
    } else {
        $years = floor($timeDiff / $year);
        if($years == 1) return 'Acum un an';
        else return 'Acum ' . $years . ' ani';
    }
}

?>