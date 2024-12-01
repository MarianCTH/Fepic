<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
header("Content-type: text/html; charset=UTF-8");
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
  header("location: ../../index");
  exit;
}

require_once '../../config/config.php';

$action = $_POST['action'];
$column = $_POST['column'];
$value = $_POST['value'];

$id_user = $_SESSION["id"];

if ($action === "notifications") {
  $sql = "UPDATE setari_notificari SET $column = $value WHERE id_user = $id_user";

  if ($db->query($sql) === TRUE) {
    echo "Database updated successfully";
  } else {
    echo "Error updating database: ";
  }
} else if ($action === "subscription") {
  $user_email = $db->real_escape_string($_SESSION["email"]);

  if ($value == 1) {
    $sql = "INSERT INTO subscription (email) VALUES ('$user_email')";

    if ($db->query($sql) === TRUE) {
      echo "Database updated successfully";
    } else {
      echo "Error updating database: ";
    }
  } else {
    $sql = "DELETE FROM subscription WHERE email = '$user_email'";

    if ($db->query($sql) === TRUE) {
      echo "Database updated successfully";
    } else {
      echo "Error updating database: ";
    }
  }

} else {
  echo "Invalid action";
}

$db->close();
?>