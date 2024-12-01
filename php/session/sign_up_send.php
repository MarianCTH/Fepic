<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);


session_start();
header("Content-type: text/html; charset=UTF-8");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../../index");
    exit;
}

include "../../config/config.php";
include "../../admin/php/logs/log.php";
$logFile = '../../admin/php/logs/activity.log';

$nume = $prenume = $password = $email = $person = "";
$errors = array();
$response = array();

if (empty(trim($_POST["nume"]))) {
    $errors["nume"] = "Vă rugăm să introduceți numele dumneavoastră.";
} else {
    $nume = trim($_POST["nume"]);
}

if (empty(trim($_POST["prenume"]))) {
    $errors["prenume"] = "Vă rugăm să introduceți prenumele dumneavoastră.";
} else {
    $prenume = trim($_POST["prenume"]);
}

if (empty(trim($_POST["email"]))) {
    $errors["email"] = "Te rugăm să introduci un email.";
} else {
    $sql = "SELECT ID FROM utilizatori WHERE Email = ?";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_email);

        $param_email = trim($_POST["email"]);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                $errors["email"] = "Acest email este deja în folosință.";
            } else {
                $email = trim($_POST["email"]);
            }
        } else {
            $errors["general"] = "Oops! Ceva nu a mers bine. Încearcă din nou.";
        }

        mysqli_stmt_close($stmt);
    }
}

if (empty(trim($_POST["person"]))) {
    $errors["person"] = "Vă rugăm să alegeți un tip de cont.";
} else {
    $person = trim($_POST["person"]);

    if ($person == 'Juridică') {
        if (empty(trim($_POST["nume_firma"]))) {
            $errors["nume_firma"] = "Vă rugăm să introduceți numele companiei dumneavoastră.";
        } else {
            $companie = trim($_POST["nume_firma"]);

            if (!preg_match("/^[A-Za-z]+$/", $companie)) {
                $errors["nume_firma"] = "Numele companiei trebuie să conțină doar litere.";
            }
        }

        if (empty(trim($_POST["rol_firma"]))) {
            $errors["rol_firma"] = "Vă rugăm să introduceți rolul dumneavoastră în companie.";
        } else {
            $rol_companie = trim($_POST["rol_firma"]);

            if (!preg_match("/^[A-Za-z]+$/", $rol_companie)) {
                $errors["rol_firma"] = "Rolul trebuie să conțină doar litere.";
            }
        }

        if (empty(trim($_POST["cui"]))) {
            $errors["cui"] = "Vă rugăm să introduceți codul CUI al firmei.";
        } else {
            $CUI = trim($_POST["cui"]);

            if (!preg_match("/^[0-9]+$/", $CUI)) {
                $errors["cui"] = "Codul CUI trebuie să conțină doar cifre.";
            }
        }

        if (empty(trim($_POST["coduri_caen"]))) {
            $errors["coduri_caen"] = "Vă rugăm să introduceți codurile CAEN ale companiei.";
        } else {
            $Coduri_CAEN = trim($_POST["coduri_caen"]);

            if (!preg_match("/^[0-9]+$/", $Coduri_CAEN)) {
                $errors["coduri_caen"] = "Codurile CAEN trebuie să conțină doar cifre.";
            }
        }
    }
}

if (empty(trim($_POST["parola"]))) {
    $errors["password"] = "Te rugăm să introduci o parolă.";
} else {
    $password = trim($_POST["parola"]);
}

if (empty($errors)) {
    require '../../PHPMailer/PHPMailerAutoload.php';
    function generateRandomKey($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $key = '';

        for ($i = 0; $i < $length; $i++) {
            $key .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $key;
    }

    $sql = "INSERT INTO utilizatori (Nume, Prenume, Email, TipCont, Parola, Status, 2FactorAuthCode) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssss", $param_nume, $param_prenume, $param_email, $param_person, $param_password, $param_status, $param_2fa_code);

        $param_nume = $nume;
        $param_prenume = $prenume;
        $param_email = $email;
        $param_person = $person;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_status = "Neverificat";
        $param_cheie = generateRandomKey();

        require_once '2Factor/GoogleAuthenticator.php';
        $ga = new PHPGangsta_GoogleAuthenticator();
        $param_2fa_code = $ga->createSecret();

        if (mysqli_stmt_execute($stmt)) {
            $user_id = mysqli_insert_id($db);
            mysqli_stmt_close($stmt);

            $sql3 = "INSERT INTO setari_notificari (id_user) VALUES (?)";
            if ($stmt3 = mysqli_prepare($db, $sql3)) {
                mysqli_stmt_bind_param($stmt3, "i", $user_id);
                mysqli_stmt_execute($stmt3);
                mysqli_stmt_close($stmt3);

                $sql4 = "INSERT INTO activare_cont (ID_user, Keyy, Remaining_time) VALUES (?, ?, ?)";
                if ($stmt4 = mysqli_prepare($db, $sql4)) {
                    $remaining_time = 30;
                    mysqli_stmt_bind_param($stmt4, "isi", $user_id, $param_cheie, $remaining_time);
                    mysqli_stmt_execute($stmt4);
                    mysqli_stmt_close($stmt4);

                    if ($param_person == 'Juridică') {
                        $sql2 = "INSERT INTO date_utilizatori (ID_utilizator, Companie, `Rol Companie`, CUI, Coduri_CAEN) VALUES (?, ?, ?, ?, ?)";
                        if ($stmt2 = mysqli_prepare($db, $sql2)) {
                            mysqli_stmt_bind_param($stmt2, "issss", $user_id, $param_companie, $param_rol_companie, $param_CUI, $param_Coduri_CAEN);
                            $param_companie = $companie;
                            $param_rol_companie = $rol_companie;
                            $param_CUI = $CUI;
                            $param_Coduri_CAEN = $Coduri_CAEN;
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else {
                            $errors["general"] = 'Oops! Ceva nu a mers bine. Încearcă din nou.';
                        }
                    } else {
                        $sql2 = "INSERT INTO date_utilizatori (ID_utilizator) VALUES (?)";
                        if ($stmt2 = mysqli_prepare($db, $sql2)) {
                            mysqli_stmt_bind_param($stmt2, "i", $user_id);
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_close($stmt2);
                        } else {
                            $errors["general"] = 'Oops! Ceva nu a mers bine. Încearcă din nou.';
                        }
                    }

                    $activationLink = 'https://' . $web_link .'/php/session/activate_account.php?user_id=' . $user_id . '&key=' . $param_cheie;

                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->SMTPAuth = true;
                    require_once '../../config/email-config.php';
                    $mail->addAddress($param_email, $param_nume . ' ' . $param_prenume);
                    $mail->Subject = 'Activare Cont';
                    $mail->Body = 'Te rugăm să dai clic pe următorul link pentru a-ți activa contul: ' . $activationLink;

                    if ($mail->send()) {
                        require_once '../notificari.php';
                        $response = array('success' => 'Contul a fost creat cu succes!<br>Vă rugăm să verificați contul prin email.');
                        sendNotification('Administrator', 'Utilizator nou: <a href="edit-user.php?id=' . $user_id . '" class="subject stretched-link text-truncate"style="max-width: 180px;">' . $param_nume . ' ' . $param_prenume . '</a>', 'new_acc');
                        logMessage('Utilizator nou înregistrat: ' . $param_nume . ' ' . $param_prenume . ' [#' . $user_id . ']');
                    } else {
                        $errors["general"] = 'Oops! Ceva nu a mers bine. Încearcă din nou.';
                    }
                } else {
                    $errors["general"] = 'Oops! Ceva nu a mers bine. Încearcă din nou.';
                }
            } else {
                $errors["general"] = 'Oops! Ceva nu a mers bine. Încearcă din nou.';
            }
        } else {
            $errors["general"] = 'Oops! Ceva nu a mers bine. Încearcă din nou.';
        }
    }
} else {
    $response = array('errors' => $errors);
}

mysqli_close($db);
echo json_encode($response);

?>