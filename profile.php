<?php
session_start();

require_once 'php/notificari.php';
header("Content-type: text/html; charset=UTF-8");
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
  header("location: index.php");
  exit;
}

require_once 'config/config.php';
$userId = $_SESSION['id'];
include "admin/php/logs/log.php";
$logFile = 'admin/php/logs/activity.log';

$user_email = $db->real_escape_string($_SESSION["email"]);

$sql = "SELECT COUNT(*) as count FROM subscription WHERE email = '$user_email'";
$result = $db->query($sql);

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $exists_subscription = $row["count"] > 0;
} else {
  $exists_subscription = false;
}


$stmt = $db->prepare("SELECT u.*, d.*, s.* FROM utilizatori u 
INNER JOIN date_utilizatori d ON u.ID = d.ID_utilizator
INNER JOIN setari_notificari s ON u.ID = s.id_user
WHERE u.ID = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt->close();
$db->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fepic - Profil</title>
  <link rel="stylesheet" href="css/icofont.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="css/modal.css">

  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <style>
    input[type='radio'] {
      accent-color: #bd7505;
    }

    #success-message {
      display: none;
      color: green;
      padding: 10px;
      transition: opacity 1s ease-in-out;
      border-radius: 6px;
      text-align: center;
      font-family: Arial, sans-serif;
      font-size: 16px;
    }

    .success-msgg {
      color: green;
      padding: 10px;
      transition: opacity 1s ease-in-out;
      border-radius: 6px;
      text-align: center;
      font-family: Arial, sans-serif;
      font-size: 16px;
    }

    .error-msgg {
      color: red;
      padding: 10px;
      transition: opacity 1s ease-in-out;
      border-radius: 6px;
      text-align: center;
      font-family: Arial, sans-serif;
      font-size: 16px;
    }

    .img-account-profile {
      height: 10rem;
    }

    .rounded-circle {
      border-radius: 50% !important;
    }

    .card {
      box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
    }

    .card .card-header {
      font-weight: 500;
    }

    .card-header:first-child {
      border-radius: 0.35rem 0.35rem 0 0;
    }

    .card-header {
      padding: 1rem 1.35rem;
      margin-bottom: 0;
      background-color: rgba(33, 40, 50, 0.03);
      border-bottom: 1px solid rgba(33, 40, 50, 0.125);
    }

    .form-control,
    .dataTable-input {
      display: block;
      width: 100%;
      padding: 0.875rem 1.125rem;
      font-size: 0.875rem;
      font-weight: 400;
      line-height: 1;
      color: #69707a;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #c5ccd6;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      border-radius: 0.35rem;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .nav-borders .nav-link.active {
      color: #0061f2;
      border-bottom-color: #0061f2;
    }

    .nav-borders .nav-link {
      color: #69707a;
      border-bottom-width: 0.125rem;
      border-bottom-style: solid;
      border-bottom-color: transparent;
      padding-top: 0.5rem;
      padding-bottom: 0.5rem;
      padding-left: 0;
      padding-right: 0;
      margin-left: 1rem;
      margin-right: 1rem;
    }

    .btn-danger-soft {
      color: white;
      background-image: linear-gradient(135deg, #f7342d, #b3271d);
      font-size: 15px;
      padding: 10px 30px;
      border-radius: 25px;
      position: relative;
      font-weight: 700;
      transition: 0.4s all;
    }

    .btn-danger-soft:hover {
      color: var(--text-white);
      opacity: 0.9;
    }

    .btn-danger-soft i {
      display: inline-block;
      font-size: 20px;
      margin-left: 4px;
      position: relative;
      top: 1px;
      transition: 0.4s all;
    }

    .btn-container {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #custom-button {
      --primary-color: #645bff;
      --secondary-color: #fff;
      --hover-color: #111;
      --arrow-width: 10px;
      --arrow-stroke: 2px;
      box-sizing: border-box;
      border: 0;
      border-radius: 25px;
      color: var(--secondary-color);
      padding: 10px 30px;
      background: var(--bg-orange-gradiunt);
      display: flex;
      transition: 0.2s background;
      align-items: center;
      gap: 0.6em;
      font-weight: bold;
    }

    #custom-button .arrow-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #custom-button .arrow {
      margin-top: 1px;
      width: var(--arrow-width);

      height: var(--arrow-stroke);
      position: relative;
      transition: 0.2s;
    }

    #custom-button .arrow::before {
      content: "";
      box-sizing: border-box;
      position: absolute;
      border: solid var(--secondary-color);
      border-width: 0 var(--arrow-stroke) var(--arrow-stroke) 0;
      display: inline-block;
      top: -3px;
      right: 3px;
      transition: 0.2s;
      padding: 3px;
      transform: rotate(-45deg);
    }



    #custom-button:hover .arrow {
      background: var(--secondary-color);
    }

    #custom-button:hover .arrow:before {
      right: 0;
    }

    .status {
      font-weight: bold;
    }

    .active {
      color: green;
    }
  </style>
</head>

<body>
  <div class="page_wrapper">

    <div id="preloader">
      <div class="circle-border">
        <div class="circle-core"></div>
      </div>
    </div>

    <div class="full_bg">
      <div class="container">
        <section class="signup_section">
          <div class="top_part">
            <a href="index" class="back_btn"><i class="icofont-arrow-left"></i> Înapoi acasă</a>
          </div>
          <div class="profile_block sign-in" style="background-color: white;">
            <div class="container-xl px-4 mt-4" id="profile">
              <nav class="nav nav-borders">
                <a class="nav-link active ms-0" href="#profile">Date personale</a>
                <a class="nav-link" href="#security">Securitate</a>
                <a class="nav-link" href="#notifications">Notificări</a>
              </nav>
              <hr class="mt-0 mb-4">
              <div class="row">
                <div class="col-xl-4">
                  <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Poză de profil</div>
                    <div class="card-body text-center">
                    <form>
                      <label for="fileToUpload">
                        <img id="profile-image" class="img-account-profile rounded-circle mb-2"
                          src="images/profile/<?php echo $row['Poza']; ?>" alt="Poza de profil">
                        <div class="small font-italic text-muted mb-4">JPG sau PNG cu o dimensiune maximă de 5 MB</div>
                      </label>
                      <label for="fileToUpload" class="btn btn_mainnanimation">
                        <i class="icofont-upload-alt"></i> Selectează imaginea
                      </label>
                      <input type="file" id="fileToUpload" style="display: none;">
                    </form>
                    </div>
                  </div>
                </div>

                <div class="col-xl-8">
                  <div class="card mb-4">
                    <div class="card-header">Detaliile Contului</div>
                      <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" id="updateData">

                          <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                              <label class="small mb-1" for="inputUsername">Nume</label>
                              <input class="form-control" id="inputUsername" name="username" type="text"
                              placeholder="Introduceți numele de utilizator" value="<?php echo $row['Nume']; ?>">
                            </div>
                            <div class="col-md-6">
                              <label class="small mb-1" for="inputPrenume">Prenume</label>
                              <input class="form-control" id="inputPrenume" type="text" name="prenume"
                                placeholder="<?php echo $row['Prenume']; ?>"
                                value="<?php echo $row['Prenume']; ?>">
                            </div>
                          </div>

                          <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                              <label class="small mb-1" for="inputEmailAddress">Adresă de email</label>
                              <input class="form-control" id="inputEmailAddress" name="email" type="email"
                                placeholder="Introduceți adresa dumneavoastră de email"
                                value="<?php echo $row['Email']; ?>">
                            </div>
                            <div class="col-md-6">
                              <label class="small mb-1" for="inputPhone">Număr de telefon</label>
                              <input class="form-control" id="inputPhone" name="phone" type="tel" placeholder="Telefon"
                                value="<?php echo $row['Telefon']; ?>">
                            </div>
                          </div>
                          
                          <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                              <label class="small mb-1" for="inputLocation">Locație</label>
                              <input class="form-control" id="inputLocation" name="location" type="text"
                                placeholder="Introduceți adresa dumneavoastră" value="<?php echo $row['Adresă']; ?>">
                            </div>
                            <div class="col-md-6">
                              <label class="small mb-1" for="inputBirthday">Data nașterii</label>
                              <input class="form-control" id="inputBirthday" name="birthday" type="date"
                                placeholder="Data nașterii" value="<?php echo $row['Data_nasterii']; ?>">
                            </div>
                          </div>
                          <?php if($row['TipCont'] == 'Juridică'){?>
                          <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                              <label class="small mb-1" for="inputOrgName">Nume organizație</label>
                              <input class="form-control" id="inputOrgName" name="orgName" type="text"
                                placeholder="Introduceți numele organizației dumneavoastră"
                                value="<?php echo $row['Companie']; ?>">
                            </div>
                            <div class="col-md-6">
                              <label class="small mb-1" for="inputRole">Rol în organizație</label>
                              <input class="form-control" id="inputRole" type="text" name="rol_org"
                                placeholder="<?php echo $row['Rol Companie']; ?>"
                                value="<?php echo $row['Rol Companie']; ?>">
                            </div>
                          </div>
                          <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                              <label class="small mb-1" for="inputCui">CUI</label>
                              <input class="form-control" id="inputCui" type="text" name="cui"
                                placeholder="<?php echo $row['CUI']; ?>" value="<?php echo $row['CUI']; ?>">
                            </div>
                            <div class="col-md-6">
                              <label class="small mb-1" for="coduriCaen">Coduri CAEN</label>
                              <input class="form-control" id="coduriCaen" type="text" name="coduri_caen"
                                placeholder="<?php echo $row['Coduri_CAEN']; ?>"
                                value="<?php echo $row['Coduri_CAEN']; ?>">
                            </div>
                          </div>
                          <?php } ?>
                          <input type="hidden" id="selectedImageName" name="selectedImageName" value="">

                          <div class="btn-container">
                            <button class="btn btn_main" type="submit" name="updateDetails">Salvează modificările<i
                                class="icofont-arrow-right"></i></button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <div class="container-xl px-4 mt-4" id="security" style="display:none;">
              <nav class="nav nav-borders">
                <a class="nav-link" href="#profile">Date personale</a>
                <a class="nav-link active ms-0" href="#security">Securitate</a>
                <a class="nav-link" href="#notifications">Notificări</a>
              </nav>
              <hr class="mt-0 mb-4">
              <div class="row">
                <div class="col-lg-8">
                  <div class="card mb-4">
                    <div class="card-header">Schimbare Parolă</div>
                    <div class="card-body">
                      <form id="passwordChangeForm" method="post">
                        <div class="mb-3">
                          <label class="small mb-1" for="currentPassword">Parolă Curentă</label>
                          <input class="form-control" id="currentPassword" name="currentPassword" type="password"
                            placeholder="Introduceți parola curentă" required>
                        </div>

                        <div class="mb-3">
                          <label class="small mb-1" for="newPassword">Parolă Nouă</label>
                          <input class="form-control" id="newPassword" name="newPassword" type="password"
                            placeholder="Introduceți parola nouă" required>
                        </div>

                        <div class="mb-3">
                          <label class="small mb-1" for="confirmPassword">Confirmare Parolă</label>
                          <input class="form-control" id="confirmPassword" name="confirmPassword" type="password"
                            placeholder="Confirmați parola nouă" required>
                        </div>
                        <button class="btn btn_main" type="submit" name="passwordChange">Schimbă parola</button>
                      </form>
                      <div id="message"></div>

                    </div>
                  </div>
                  <div class="card mb-4">
                    <div class="card-header">Preferințe de Securitate</div>
                    <div class="card-body">
                      <h5 class="mb-1">Confidențialitate Cont</h5>
                      <p class="small text-muted">Prin setarea contului la privat, informațiile profilului și postările
                        dumneavoastră nu vor fi vizibile utilizatorilor.</p>
                      <form>
                        <div class="form-check">
                          <input class="form-check-input orange-radio" id="radioPrivacy1" type="radio"
                            name="radioPrivacy" value="1" <?php if ($row['Confidentialitate_securitate'] == 1)
                              echo 'checked'; ?>>
                          <label class="form-check-label" for="radioPrivacy1">Public (datele dumneavoastră sunt
                            disponibile pentru toți utilizatorii)</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input orange-radio" id="radioPrivacy2" type="radio"
                            name="radioPrivacy" value="0" <?php if ($row['Confidentialitate_securitate'] == 0)
                              echo 'checked'; ?>>
                          <label class="form-check-label" for="radioPrivacy2">Privat (datele personale nu vor fi
                            dezvăluite celorlalți utilizatori)</label>
                        </div>
                      </form>

                      <hr class="my-4">
                      <h5 class="mb-1">Partajare Date</h5>
                      <p class="small text-muted">Partajarea datelor de utilizare ne poate ajuta să îmbunătățim
                        produsele noastre și să
                        servim mai bine utilizatorii noștri pe măsură ce navighează prin aplicația noastră. Când
                        acceptați să partajați
                        datele de utilizare cu noi, rapoartele de erori și analizele de utilizare vor fi trimise automat
                        echipei noastre
                        de dezvoltare în scopul investigației.</p>
                      <form>
                        <div class="form-check">
                          <input class="form-check-input" id="dateSecuritate1" type="radio" name="dateSecuritate"
                            value="1" <?php if ($row['Date_securitate'] == 1)
                              echo 'checked'; ?>>
                          <label class="form-check-label" for="dateSecuritate1">Da, partajează datele și rapoartele de
                            erori
                            cu
                            dezvoltatorii aplicației</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" id="dateSecuritate2" type="radio" name="dateSecuritate"
                            value="0" <?php if ($row['Date_securitate'] == 0)
                              echo 'checked'; ?>>
                          <label class="form-check-label" for="dateSecuritate2">Nu, limitează partajarea datelor mele cu
                            dezvoltatorii
                            aplicației</label>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="card mb-4">
                    <div class="card-header">Autentificare cu doi factori</div>
                    <div class="card-body">
                      <p>Adăugați un nivel adițional de securitate contului dumneavoastră prin activarea autentificării în doi factori, folosind Google Authenticator. Acest proces implică generarea de coduri de autentificare pe dispozitivul dvs. mobil.</p>
                      <div class="container" style="display: flex;justify-content: center;align-items: center;">

                        <?php if ($row['2FactorAuth'] == 0) {
                          echo '<button id="custom-button" onclick="open2FAModal()">Activează 2FA<div class="arrow-wrapper"><div class="arrow"></div></div></button>';
                        } 
                        else{
                          echo '
                          <div class = "text-center">
                            <div>                         
                              <p>Autentificare în 2 factori: <span class="status active">Activată</span> (Google Authenticator App)</p>
                            </div> 
                            <div class="container" style="display: flex;justify-content: center;align-items: center;">
                              <button id="custom-button" id="deactivate-2fa" onclick="deactivate2FA()">Dezactivează</button>
                            </div> 
                          </div>';
                        }?>
                      </div>
                    </div>
                  </div>
                  <div class="card mb-4">
                    <div class="card-header">Ștergere Cont</div>
                    <div class="card-body">
                      <p>Ștergerea contului este o acțiune permanentă și nu poate fi anulată. Dacă sunteți sigur că
                        doriți să ștergeți
                        contul dumneavoastră, selectați butonul de mai jos.</p>
                      <div class="container" style="display: flex;justify-content: center;align-items: center;">

                        <button class="btn btn-danger-soft" type="button" onclick="confirmDelete()"><i
                            class="icofont-ui-delete"></i> Șterge contul</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="container-xl px-4 mt-4" id="notifications" style="display:none;">
              <nav class="nav nav-borders">
                <a class="nav-link" href="#profile">Date personale</a>
                <a class="nav-link" href="#security">Securitate</a>
                <a class="nav-link active ms-0" href="#notifications">Notificări</a>
              </nav>
              <hr class="mt-0 mb-4">
              <div class="row">
                  <div class="col-lg-8">
                    <div class="card card-header-actions mb-4">
                      <div class="card-header">
                        Notificări prin email
                      </div>
                      <div class="card-body">
                        <div class="mb-3">
                          <label class="small mb-1" for="inputNotificationEmail">Email de notificare implicit</label>
                          <input class="form-control" id="inputNotificationEmail" type="email"
                            value="<?php echo $row['Email']; ?>" disabled="">
                        </div>
                        <div class="mb-0">
                          <label class="small mb-2">Alegeți tipurile de actualizări prin email pe care le
                            primiți</label>
                          <div class="form-check mb-2">
                            <input class="form-check-input" id="checkAccountChanges" name="checkAccountChanges"
                              type="checkbox" <?php if ($row['account_change'] == 1)
                                echo "checked"; ?>>
                            <label class="form-check-label" for="checkAccountChanges">Modificări efectuate asupra
                              contului
                              tău</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" id="checkSecurity" name="checkSecurity" type="checkbox" checked disabled="">
                            <label class="form-check-label" for="checkSecurity">Alerte de securitate</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card card-header-actions mb-4">
                      <div class="card-header">
                        Notificări prin push
                      </div>
                      <div class="card-body">
                        <div class="mb-0">
                          <label class="small mb-2">Alegeți tipurile de notificări prin push pe care le primiți</label>
                          <div class="form-check mb-2">
                            <input class="form-check-input" id="newPost" name="newPost" type="checkbox"
                              <?php if ($row['blog_post'] == 1)
                                echo "checked"; ?>>
                            <label class="form-check-label" for="newPost">Postări noi pe blog</label>
                          </div>
                          <div class="form-check mb-2">
                            <input class="form-check-input" id="checkSmsComment" name="checkSmsComment" type="checkbox"
                              <?php if ($row['comment_post'] == 1)
                                echo "checked"; ?>>
                            <label class="form-check-label" for="checkSmsComment">Cineva comentează la postarea
                              ta</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" id="checkSmsPrivateMessage" name="checkSmsPrivateMessage"
                              type="checkbox" <?php if ($row['message'] == 1)
                                echo "checked"; ?>>
                            <label class="form-check-label" for="checkSmsPrivateMessage">Primești un mesaj
                              privat</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="card">
                      <div class="card-header">Preferințe de notificare</div>
                      <div class="card-body">
                        <div class="form-check mb-3">
                          <input class="form-check-input" id="autoNotificationBlog" name="autoNotificationBlog" type="checkbox" 
                          <?php if ($exists_subscription) echo "checked"; ?>>
                          <label class="form-check-label" for="autoNotificationBlog">Abonare automată la postările
                            noi</label>
                        </div>
                        <form method="post" action="php/profile/update_settings.php">
                          <div class="container" style="display: flex; justify-content: center; align-items: center;">
                            <button class="btn btn_mainnotif">Oprește notificările<i
                                class="icofont-alarm"></i></button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
              </div>

            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <div class="modal fade show" id="modal-info-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-info" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-info-body d-flex">
            <div class="modal-info-icon warning">
              <img src="admin/img/svg/alert-circle.svg" alt="alert-circle" class="svg">
            </div>
            <div class="modal-info-text">
              <h6>Sunteți sigur că doriți să ștergeți contul dumneavoastră?</h6>
              <p>Ștergerea contului este o acțiune permanentă și nu poate fi anulată. </p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light btn-outlined btn-sm" data-dismiss="modal">Nu</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" id="deleteButton">Sunt
            Sigur</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="twoFactorModal" tabindex="-1" role="dialog" aria-labelledby="twoFactorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="images/google_auth.png" alt="Google Authenticator" width="30">
          <h5 class="modal-title" id="twoFactorModalLabel">Configurați autentificarea cu doi factori</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php
          require_once 'php/session/2Factor/GoogleAuthenticator.php';
          $ga = new PHPGangsta_GoogleAuthenticator();
          $secret = $_SESSION['secretKey'];
          $qrCodeUrl = $ga->getQRCodeGoogleUrl('Fepic:' . $_SESSION['email'], $secret);
          ?>
          <p class="text-center">Scanați codul QR de mai jos folosind aplicația Google Authenticator:</p>
          <div class="text-center">
            <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code" class="img-fluid">
          </div>
          <form id="authenticator-form" class="mt-4 text-center">
            <input type="hidden" id="secretKeyInput" name="secret_key" value="<?php echo $secret; ?>">
            <div class="form-group row justify-content-between">
              <div class="col"></div>
              <div class="col-md-auto">
                <label for="authenticator-code">Introdu codul din aplicație:</label>
                <input type="text" class="form-control form-control-sm text-center" id="authenticator-code"
                  name="authenticator_code" placeholder="Introduceți codul">
              </div>
              <div class="col"></div>
            </div>
            <p class="error" id="wrong_code"></p>

            <button type="submit" class="btn btn-primary">Activează</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-info-success modal fade show" id="success-modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-info" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-info-body d-flex">
            <div class="modal-info-icon primary">
              <img src="admin/img/svg/alert-circle.svg" alt="alert-circle" class="svg">
            </div>
            <div class="modal-info-text">
              <p></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const navLinks = document.querySelectorAll(".nav-link");

      navLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
          event.preventDefault();
          const target = this.getAttribute("href");
          const sections = document.querySelectorAll(".container-xl");

          sections.forEach(function (section) {
            if (section.getAttribute("id") === target.slice(1)) {
              section.style.display = "block";
            } else {
              section.style.display = "none";
            }
          });
        });
      });
    });
  </script>
  <script>
    function confirmDelete() {
      $('#modal-info-delete').modal('show');
    }
    document.getElementById('deleteButton').addEventListener('click', function () {
      const url = `php/profile/delete_account.php?action=delete`;

      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error('Response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.status === 'success') {
            window.location.href = "sign-in";
          }
        })
        .catch(error => {
          console.error('Fetch error:', error);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
      const fileInput = document.getElementById('fileToUpload');
      const selectedImageNameInput = document.getElementById('selectedImageName');
      const profileImage = document.getElementById('profile-image');
      const originalPhoto = '<?php echo $row['Poza']; ?>';
      let selectedImageName = '';

      fileInput.addEventListener('change', function (event) {
        const selectedFile = event.target.files[0];
        if (selectedFile) {
          const allowedFormats = ['image/jpeg', 'image/png'];
          if (allowedFormats.includes(selectedFile.type)) {
            const fileSizeMB = selectedFile.size / (1024 * 1024);
            if (fileSizeMB <= 5) {
              selectedImageName = selectedFile.name;
              selectedImageNameInput.value = selectedImageName;
              profileImage.src = URL.createObjectURL(selectedFile);
            } else {
              alert('Imaginea depășește dimensiunea maximă de 5 MB.');
            }
          } else {
            alert('Formatul imaginii trebuie să fie JPG sau PNG.');
          }
        }
      });

      document.getElementById('updateData').addEventListener('submit', function (event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        const fileToUpload = fileInput.files[0];
        formData.append('fileToUpload', fileToUpload);
        formData.append('originalPhoto', originalPhoto);
        
        fetch('php/profile/update_profile.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              $('#success-modal').modal('show');
              const successModal = document.getElementById('success-modal');

              const modalInfoText = successModal.querySelector('.modal-info-text p');

              modalInfoText.textContent = data.message;
            } else if (data.status === 'error'){
              $('#success-modal').modal('show');
              const successModal = document.getElementById('success-modal');

              const modalInfoText = successModal.querySelector('.modal-info-text p');

              modalInfoText.textContent = data.message;
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      });
    });
  </script>
  <script>
    const radioButtons = document.querySelectorAll('input[name="radioPrivacy"]');
    const dateSecuritate = document.querySelectorAll('input[name="dateSecuritate"]');

    function handleAjaxRequest(value, inputType) {
      $.ajax({
        url: 'php/profile/update_security_data',
        method: 'POST',
        data: { value: value, inputType: inputType },
        success: function (response) {
          console.log(response);
        },
        error: function (xhr, status, error) {
          console.error(error);
        }
      });
    }

    radioButtons.forEach(button => {
      button.addEventListener('change', function () {
        const value = this.value;
        handleAjaxRequest(value, 'radioPrivacy');
      });
    });

    dateSecuritate.forEach(button => {
      button.addEventListener('change', function () {
        const value = this.value;
        handleAjaxRequest(value, 'dateSecuritate');
      });
    });

  </script>
  <script>
    function updateDatabase(action, column, value) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "php/profile/update_setari_notif.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          console.log(xhr.responseText);
        }
      };
      xhr.send("action=" + action + "&column=" + column + "&value=" + value);
    }

    document.addEventListener("DOMContentLoaded", function () {
      var checkAccountChanges = document.getElementById("checkAccountChanges");
      var newPost = document.getElementById("newPost");
      var checkSmsComment = document.getElementById("checkSmsComment");
      var checkSmsPrivateMessage = document.getElementById("checkSmsPrivateMessage");
      var autoNotificationBlog = document.getElementById("autoNotificationBlog");

      checkAccountChanges.addEventListener("change", function () {
        updateDatabase("notifications", "account_change", this.checked ? 1 : 0);
      });

      newPost.addEventListener("change", function () {
        updateDatabase("notifications", "blog_post", this.checked ? 1 : 0);
      });

      checkSmsComment.addEventListener("change", function () {
        updateDatabase("notifications", "comment_post", this.checked ? 1 : 0);
      });

      checkSmsPrivateMessage.addEventListener("change", function () {
        updateDatabase("notifications", "message", this.checked ? 1 : 0);
      });

      autoNotificationBlog.addEventListener("change", function () {
        updateDatabase("subscription", "", this.checked ? 1 : 0);
      });
    });
  </script>
  <script>
    const form = document.getElementById('passwordChangeForm');
    const messageDiv = document.getElementById('message');

    form.addEventListener('submit', function (event) {
      event.preventDefault();

      const currentPassword = document.getElementById('currentPassword').value;
      const newPassword = document.getElementById('newPassword').value;
      const confirmPassword = document.getElementById('confirmPassword').value;

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'php/profile/update_password.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.hasOwnProperty('message')) {
            showMessage(response.message);
            document.getElementById("currentPassword").value = "";
            document.getElementById("newPassword").value = "";
            document.getElementById("confirmPassword").value = "";
          }
        }
      };

      const params = 'currentPassword=' + encodeURIComponent(currentPassword) +
        '&newPassword=' + encodeURIComponent(newPassword) +
        '&confirmPassword=' + encodeURIComponent(confirmPassword) +
        '&passwordChange=true';

      xhr.send(params);
    });

    function showMessage(message) {
      messageDiv.innerHTML = message;

      messageDiv.style.display = 'block';
      setTimeout(function () {
        messageDiv.style.display = 'none';
      }, 3000);
    }
  </script>
  <script>

    function open2FAModal() {
      $('#twoFactorModal').modal('show');

    }
    $(document).ready(function () {
      $('#authenticator-form').submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
          type: 'POST',
          url: 'php/profile/validate_2fa.php',
          data: formData,
          success: function (response) {
            if (response === 'valid') {
              $('#twoFactorModal').modal('hide');
              const successModal = document.getElementById('success-modal');

              const modalInfoText = successModal.querySelector('.modal-info-text p');

              modalInfoText.textContent = "Ați activat autentificarea în 2 factori ! !";
              $('#success-modal').modal('show');

              setTimeout(function () {
                location.reload();
              }, 3000);
            }
            else {
              $("#wrong_code").html("Codul este greșit !").show();
            }
          },
          error: function () {
            alert('An error occurred during validation. Please try again.');
          }
        });
      });
    });

  </script>
  <script>
    function deactivate2FA() {
      if (confirm("Doriți să dezactivați autentificarea în 2 factori?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "php/profile/deactivate-2fa.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText.trim();
            if (response === 'success') {
              alert("Autentificarea în 2 factori a fost dezactivată.");
              location.reload();
            } else {
              alert("A apărut o eroare. Autentificarea în 2 factori nu a fost dezactivată.");
            }
          }
        };
        xhr.send();
      }
    }
  </script>

</body>

</html>