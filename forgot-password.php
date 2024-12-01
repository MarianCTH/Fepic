<?php
session_start();
header("Content-type: text/html; charset=UTF-8");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: index.php");
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
            <a href="index.php" class="back_btn"><i class="icofont-arrow-left"></i> Înapoi acasă</a>
          </div>

          <div class="profile_block sign-in">
            <div class="profile_side">
              <div class="top_side">
                <a href="index.php"><img src="images/new/Logo.png" alt="image" style="margin-bottom:15px;"></a>
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
            <div class="signup_form">
              <div class="section_title">
                <h2>Resetare parolă</h2>
                <p>Ați uitat parola?<br>Introduceți mai jos adresa dumneavoastră de e-mail pentru a începe procesul de
                  recuperare.</p>
              </div>
              <div class="section_form">
                <form id="reset-form" method="POST">
                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Adresa de email" required>
                  </div>
                  <div class="form-group">
                    <button class="btn btn_main" type="submit" name="password-reset-token">Trimite <i
                        class="icofont-arrow-right"></i></button>
                  </div>
                  <div id="error-message"></div>
                  <div id="success-message"></div>
                </form>
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
  <script>
    $(document).ready(function () {
      $('#reset-form').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
          type: 'POST',
          url: 'php/session/forgot_pass_request.php',
          data: formData,
          dataType: 'json',
          success: function (response) {
            if (response.error) {
              $('#error-message').html(response.error).show();
              $('#success-message').hide();
            } else {
              $('#success-message').html(response.correct).show();
              $('#error-message').hide();
            }
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
          }
        });
      });
    });
  </script>
</body>


</html>