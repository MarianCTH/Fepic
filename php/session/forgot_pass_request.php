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

include('../../config/config.php');
$error = "";
$correct = "";

if (isset($_POST["email"]) && (!empty($_POST["email"]))) {
  $email = $_POST["email"];
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  if (!$email) {
    $error = "<p>Adresă de e-mail invalidă, vă rugăm să introduceți o adresă de e-mail validă!</p>";
  } else {
    $email = mysqli_real_escape_string($db, $email);
    $sel_query = "SELECT * FROM `utilizatori` WHERE Email = '" . $email . "'";
    $results = mysqli_query($db, $sel_query);
    $row = mysqli_num_rows($results);
    if ($row == 0) {
      $error .= "<p>Niciun utilizator nu este înregistrat cu această adresă de e-mail!</p>";
    } else {
      $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
      $expDate = date("Y-m-d H:i:s", $expFormat);
      $key = md5(2418 * 2 + (int) $email);
      $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
      $key = $key . $addKey;

      mysqli_query($db, "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`) VALUES ('" . $email . "', '" . $key . "', '" . $expDate . "')");
      $output = '<body>';
      $output .= '<p>Dragă utilizator,</p>';
      $output .= '<p>Vă rugăm să faceți clic pe următorul link pentru a vă reseta parola.</p>';
      $output .= '<p>-------------------------------------------------------------</p>';
      $output .= '<p><a href="https://' . $web_link . '/reset-password.php?key=' . $key . '&email=' . $email . '&action=reset" target="_blank">https://' . $web_link . '/forgot-password/reset-password.php?key=' . $key . '&email=' . $email . '&action=reset</a></p>';
      $output .= '<p>-------------------------------------------------------------</p>';
      $output .= '<p>Asigurați-vă că copiați întregul link în browser. Linkul va expira după 30 de minute din motive de securitate.</p>';
      $output .= '<p>Dacă nu ați solicitat acest e-mail cu parola uitată, nicio acțiune nu este necesară, parola dvs. nu va fi resetată. Cu toate acestea, poate doriți să vă conectați în contul dvs. și să schimbați parola din motive de securitate.</p>';
      $output .= '<p>Mulțumim,</p>';
      $output .= '<p>Echipa Fepic</p>';
      $output .= '</body>';
      $body = $output;
      $subject = "Resetare parola - Fepic";

      $email_to = $email;
      $fromserver = "marian.chiticariu@zapptelecom.ro";
      require("../../PHPMailer/PHPMailerAutoload.php");
      $mail = new PHPMailer();
      $mail->IsSMTP();
      require_once('../../config/email-config.php');
      $mail->SMTPAuth = true;
      $mail->IsHTML(true);
      $mail->Sender = $fromserver;
      $mail->Subject = $subject;
      $mail->Body = $body;
      $mail->AddAddress($email_to);

      if (!$mail->Send()) {
        $error = "Mailer Error: " . $mail->ErrorInfo;
      } else {
        $correct = "<div class='error'>
              <p>V-a fost trimis un e-mail cu instrucțiuni despre cum să vă resetați parola.</p>
              </div><br /><br /><br />";
      }
    }
  }

  $response = array(
    'error' => $error,
    'correct' => $correct
  );
  echo json_encode($response);
  exit();
}
?>