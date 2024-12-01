<?php 
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

include "../../config/config.php";
include "2Factor/GoogleAuthenticator.php";

session_start();
header("Content-type: application/json; charset=UTF-8");

$FactorAuthCode = $_POST['FactorAuthCode'];
$UserInputAuthCode = $_POST['UserInputAuthCode'];

$ga = new PHPGangsta_GoogleAuthenticator();
if ($ga->verifyCode($FactorAuthCode, $UserInputAuthCode, 2)) {
    $response["goodCode"] = true;
}
else{
    $response["message"] = "Codul introdus este gresit !";

}
echo json_encode($response);