<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();

include "../../config/config.php";
include "../../admin/php/logs/log.php";

$logFile = '../../admin/php/logs/activity.log';

header("Content-type: application/json; charset=UTF-8");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function parseJwtForEmail($token)
    {
        $base64Url = explode('.', $token)[1];
        $base64 = str_replace(['-', '_'], ['+', '/'], $base64Url);
        $jsonPayload = urldecode(base64_decode(strtr($base64, '-_', '+/')));

        $payload = json_decode($jsonPayload, true);

        if (isset($payload['email'])) {
            return $payload['email'];
        }

        return null;
    }

    if (isset($_POST["google_auth_token"])) {
        $email_test = parseJwtForEmail($_POST["google_auth_token"]);

        error_log($email_test);
        if ($email_test) {
            $email = $email_test;
            $sql = "SELECT ID, Nume, Prenume, Email, Parola, Rol, Status, Poza, TipCont, 2FactorAuthCode FROM utilizatori WHERE Email = ?";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $email);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $username, $prenume, $dbEmail, $hashed_password, $role, $status, $poza, $tipCont, $secretKey);
                        if (mysqli_stmt_fetch($stmt)) {
                            if ($status == 'Activ') {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                $_SESSION["prenume"] = $prenume;
                                $_SESSION["email"] = $dbEmail;
                                $_SESSION["rol"] = $role;
                                $_SESSION["profilePicture"] = $poza;
                                $_SESSION['TipCont'] = $tipCont;
                                $_SESSION['secretKey'] = $secretKey;

                                if ($role == "Administrator") {
                                    $_SESSION['theme'] = 'light';
                                    $_SESSION['Navbar_type'] = 'side';
                                }
                                logMessage('Utilizatorul ' . $_SESSION["username"] . ' ' . $_SESSION["prenume"] . ' [#' . $_SESSION["id"] . '] s-a autentificat.');
                                $response["success"] = true;
                                $response["message"] = "Autentificare reușită";
                            }
                        } else {
                            $response["message"] = "Contul nu este activ.";
                        }
                    }
                    else{
                        $response["message"] = "Nu există nici un cont cu această adresă de email.";
                    }
                }
            } else {
                $response["message"] = "Failed to authenticate Google token.";
            }
        } else {
            $response["message"] = "Metoda de request incorectă.";
        }
    } else {
        $email = trim($_POST["email"]);
        $password = trim($_POST["parola"]);

        if (empty($email)) {
            $response["message"] = "Introduceți un email.";
        } elseif (empty($password)) {
            $response["message"] = "Introduceți o parolă.";
        } else {
            $sql = "SELECT ID, Nume, Prenume, Email, Parola, Rol, Status, Poza, TipCont, 2FactorAuthCode FROM utilizatori WHERE Email = ?";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $email);

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $username, $prenume, $dbEmail, $hashed_password, $role, $status, $poza, $tipCont, $secretKey);
                        if (mysqli_stmt_fetch($stmt)) {
                            if (password_verify($password, $hashed_password)) {
                                if ($status == 'Activ') {
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;
                                    $_SESSION["prenume"] = $prenume;
                                    $_SESSION["email"] = $dbEmail;
                                    $_SESSION["rol"] = $role;
                                    $_SESSION["profilePicture"] = $poza;
                                    $_SESSION['TipCont'] = $tipCont;
                                    $_SESSION['secretKey'] = $secretKey;

                                    if ($role == "Administrator") {
                                        $_SESSION['theme'] = 'light';
                                        $_SESSION['Navbar_type'] = 'side';
                                    }
                                    logMessage('Utilizatorul ' . $_SESSION["username"] . ' ' . $_SESSION["prenume"] . ' [#' . $_SESSION["id"] . '] s-a autentificat.');
                                    $response["success"] = true;
                                    $response["message"] = "Autentificare reușită";
                                } else {
                                    $response["message"] = "Contul nu este activ.";
                                }
                            } else {
                                $response["message"] = "Parola sau email incorect.";
                            }
                        }
                    } else {
                        $response["message"] = "Parola sau email incorect.";
                    }
                } else {
                    $response["message"] = "Oops! Ceva nu a mers bine. Te rog încearcă din nou.";
                }

                mysqli_stmt_close($stmt);
            } else {
                $response["message"] = "Oops! Ceva nu a mers bine. Te rog încearcă din nou.";
            }
        }
    }
}

mysqli_close($db);

echo json_encode($response);
?>