<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
require_once '../../config/config.php';

$event_code = $_GET['event_code'];

$query = "SELECT Name, StartDate, EndDate, ArticleLink, Banner FROM events WHERE ID_targ = $event_code";
$result = $db->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $event_name = $row['Name'];
    $start_date = $row['StartDate'];
    $end_date = $row['EndDate'];
    $article_link= $row['ArticleLink'];
    $banner= $row['Banner'];

    error_log($article_link);
    $event_data = array(
        "event_name" => $event_name,
        "article_link" => $article_link,
        "banner" => $banner,
        "start_date" => $start_date,
        "end_date" => $end_date
    );
    echo json_encode($event_data);
} else {
    echo "Event not found";
}

$db->close();