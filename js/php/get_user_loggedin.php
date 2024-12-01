<?php
session_start();

$response = array(
  'isLoggedIn' => isset($_SESSION['loggedin']) && $_SESSION['loggedin'],
  'username' => isset($_SESSION['username']) ? $_SESSION['username'] . ' ' . $_SESSION['prenume'] : '',
  'profile_pic' => isset($_SESSION['profilePicture']) ? $_SESSION["profilePicture"] : ''
);

header('Content-Type: application/json');
echo json_encode($response);
?>
