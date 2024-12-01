<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

include "../../config/config.php";
session_start();
header("Content-type: application/json; charset=UTF-8");

$response = array("success" => false, "message" => "");

$email = $password = "";
$email_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $response["message"] .= "Introduceți un email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["parola"]))) {
        $response["message"] .= "Introduceți o parolă.";
    } else {
        $password = trim($_POST["parola"]);
    }

    if (empty($email_err) && empty($password_err)) {
        if (isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts']++;

            if ($_SESSION['login_attempts'] > 5) {
                $now = time();
                if (!isset($_SESSION['login_timeout']) || ($_SESSION['login_timeout'] + (15 * 60) <= $now)) {
                    $_SESSION['login_timeout'] = $now;
                    $_SESSION['login_attempts'] = 0;
                } else {
                    $response["message"] = "Prea multe încercări eșuate. Accesul la autentificare este blocat pentru 15 minute.";
                    echo json_encode($response);
                    exit;
                }
            }
        } else {
            $_SESSION['login_attempts'] = 1;
        }

        $check_sql = "SELECT 2FactorAuth, Parola, Status, 2FactorAuthCode FROM utilizatori WHERE Email = ?";
        if ($stmt_check = mysqli_prepare($db, $check_sql)) {
            mysqli_stmt_bind_param($stmt_check, "s", $param_email);
            $param_email = $email;

            if (mysqli_stmt_execute($stmt_check)) {
                mysqli_stmt_store_result($stmt_check);

                if (mysqli_stmt_num_rows($stmt_check) == 1) {
                    mysqli_stmt_bind_result($stmt_check, $user2FAStatus, $hashed_password, $AccountStatus, $FactorAuthCode);
                    mysqli_stmt_fetch($stmt_check);

                    if (password_verify($password, $hashed_password)) {
                        $_SESSION['login_attempts'] = 0;

                        if ($AccountStatus == 'Activ') {
                            if ($user2FAStatus == 1) {
                                $response["requires2FA"] = true;
                                $response["FactorAuthCode"] = $FactorAuthCode;
                            } else {
                                $response["loginSuccess"] = true;
                            }
                        } else if ($AccountStatus == 'Neverificat') {
                            $response["message"] = "Contul nu este verificat";
                            $response["unverified_account"] = true;
                        } else if ($AccountStatus == 'Blocat') {
                            $response["message"] = "Cont blocat";
                        }
                    } else {
                        $response["message"] = "Parola sau nume de utilizator invalide.";
                    }
                } else {
                    $response["message"] = "Parola sau nume de utilizator invalide.";
                }
            } else {
                $response["message"] = "Oops! Ceva nu a mers bine. Te rog încearcă din nou.";
            }

            mysqli_stmt_close($stmt_check);
        }
    }
}

echo json_encode($response);