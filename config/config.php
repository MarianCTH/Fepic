<?php 
$nume = "Fepic";
$web_link = "fepic.zappnet.ro";

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'zapptelecom_fepic');

$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$db->set_charset("utf8mb4");

if($db === false){
    die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
}
date_default_timezone_set('Europe/Bucharest');

?>