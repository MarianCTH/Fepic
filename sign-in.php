<?php
session_start();
header("Content-type: text/html; charset=UTF-8");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: index");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fepic - Autentificare</title>
  <link rel="stylesheet" href="css/icofont.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/modal.css">
  <script src="https://accounts.google.com/gsi/client"></script>

  <style>
    a.disabled {
      color: gray;
      pointer-events: none;
      text-decoration: none;
      cursor: not-allowed;
    }

    .center-container {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    :root {
      $buttons-border-radius: 50px;
      $buttons-primary-background-color: #4776e6;
      /*#8e54e9;*/
      $buttons-primary-color: #fff;
    }

    .modal-header {
      border-bottom: 0px !important;
    }

    /* Add these styles to your existing CSS or within a <style> tag */
    .modal-header h1 {
      position: relative;
      display: inline-block;
      color: #000;
      font-size: 2em;
      font-weight: 400;
      text-transform: uppercase;
      text-align: center;
      margin: 0 0 20px;
      padding: 0;
    }

    .modal-header h1:after {
      display: block;
      background: #000;
      content: '';
      height: 3px;
      width: 50%;
      margin: 20px auto 0;
      padding: 0;
    }

    .form {
      display: block;
    }

    .form__group {
      margin: 10px 0 0;
    }

    .form__group--error.form__pincode>input {
      background-color: #eb3b3b;
    }

    .form__group--error.form__pincode>input[disabled] {
      background-color: #eb3b3b;
      color: #fff;
      opacity: 1;
    }

    .form__group--success.form__pincode>input {
      background-color: #32c832;
    }

    .form__group--success.form__pincode>input[disabled] {
      background-color: #32c832;
      color: #fff;
      opacity: 1;
    }

    .form__pincode {
      display: block;
      width: 100%;
      margin: 10px auto 20px;
      padding: 0;
      clear: both;
    }

    .form__pincode>label {
      display: block;
      text-align: center;
      margin: 10px 0;
    }

    .form__pincode>input[type="number"] {
      -moz-appearance: none;
      -webkit-appearance: none;
      appearance: none;
    }

    .form__pincode>input {
      display: inline-block;
      float: left;
      width: 15%;
      height: 50px;
      line-height: 48px;
      text-align: center;
      font-size: 2em;
      color: #181819;
      border: 0;
      border-bottom: 2px solid rgba(0, 0, 0, 0.3);
      border-radius: 2px 2px 0 0;
      transition: background-color 0.3s, color 0.3s, opacity 0.3s;
      cursor: default;
      user-select: none;
      margin: 0;
      margin-top: 10px;
      margin-right: 2%;
      padding: 0;
    }

    .form__pincode>input:focus {
      outline: 0;
      box-shadow: none;
      border-color: #ff7133;
      animation: border-pulsate 1.5s infinite;
      -webkit-tap-highlight-color: transparent;
    }

    .form__pincode>input:last-child {
      margin-right: 0;
    }

    .form__pincode>input[disabled] {
      background: #eee;
      opacity: 1;
    }

    .form__buttons {
      text-align: center;
      margin: 7rem auto 1rem auto;
      padding: 10px 0 0;
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

          <div class="profile_block sign-in">
            <div class="profile_side">
              <div class="top_side">
                <a href="index"><img src="images/new/Logo.png" alt="image" style="margin-bottom:15px;"></a>
                <p>Federația Patronatelor din Industriile Creative este reprezentată la nivelul Consiliului de Export al
                  României. Patronatele individual, dar şi Federația, sunt afiliate Uniunii Generale a Industriașilor
                  din România şi au astfel reprezentativitate naţională conform legii patronatelor.</p>
              </div>
              <div>
                <div class="rating_platform">
                  <div class="img">
                    <img src="images/membri/fit1-1.png" alt="image">
                  </div>
                  <div class="text">
                    <div class="rating">
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                    </div>
                    <span>FIT - Future In Textiles</span>
                  </div>
                </div>
                <div class="rating_platform">
                  <div class="img">
                    <img src="images/membri/crfm-1.png" alt="image">
                  </div>
                  <div class="text">
                    <div class="rating">
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                    </div>
                    <span>CRFM - Creative Romanian Film Makers</span>
                  </div>
                </div>
                <div class="rating_platform">
                  <div class="img">
                    <img src="images/membri/rama.png" alt="image">
                  </div>
                  <div class="text">
                    <div class="rating">
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                    </div>
                    <span>RAMA - Romanian Advertising & Media Association</span>
                  </div>
                </div>
                <div class="rating_platform">
                  <div class="img">
                    <img src="images/membri/apic-1.png" alt="image">
                  </div>
                  <div class="text">
                    <div class="rating">
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                    </div>
                    <span>APIC - Asociatia Patronatelor din Industriile Creative</span>
                  </div>
                </div>
                <div class="rating_platform">
                  <div class="img">
                    <img src="images/membri/upfr-1.png" alt="image">
                  </div>
                  <div class="text">
                    <div class="rating">
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                      <span><i class="icofont-star"></i></span>
                    </div>
                    <span>UPFR - Uniunea Producatorilor de Fonograme</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="signup_form" id="signin-form">
              <div class="section_title">
                <h2>Bine ai venit</h2>
                <p>Vă rugăm să vă autentificați pentru a accesa <br>contul dumneavoastră</p>
              </div>
              <div class="section_form">
                <form action="" method="post">
                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <input type="password" name="parola" class="form-control" placeholder="Parolă">
                    <small><a href="forgot-password" style="margin-left: 15px">Ai uitat parola ?</a></small>
                  </div>
                  <div class="form-group">
                    <button class="btn btn_main" type="submit" name="autentificare">Autentificare <i
                        class="icofont-arrow-right"></i></button>
                  </div>
                </form>
                <div id="login-error" class="error2"></div>

              </div>
              <p class="or_block">
                <span>SAU</span>
              </p>
              <div class="or_option">
                <p>Autentifică-te cu adresa de email</p>
                <div id="g_id_onload"
                  data-client_id="472405072277-sd2518bdq897tfsacjta7cl01bmkf1bp.apps.googleusercontent.com"
                  data-context="signin" data-ux_mode="popup" data-callback="handleCredentialResponse"
                  data-auto_prompt="false">
                </div>

                <div class="center-container">
                  <div class="g_id_signin" data-type="standard" data-shape="pill" data-theme="outline"
                    data-text="signin_with" data-size="large" data-logo_alignment="left">
                  </div>
                </div>

                <p>Nu ai un cont? <a href="sign-up">Înregistrează-te aici</a></p>
              </div>

            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <script src="js/jquery.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <script src="js/jquery.cookie.js"></script>
  <script src="js/sign_in.js"></script>

</body>


</html>