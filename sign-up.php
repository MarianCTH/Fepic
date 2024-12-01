<?php
session_start();

header("Content-type: text/html; charset=UTF-8");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: index.php");
  exit;
}
$nume_err = $prenume_err = $password_err = $email_err = $person_err = "";

?>

<!DOCTYPE html>
<html lang="en">


<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fepic - Înscriere</title>

  <link rel="stylesheet" href="css/icofont.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <style>
    input[type='radio'] {
      accent-color: #6a49f2;
    }

    .profile_side {
      transition: transform 0.5s;
    }

    .signup_form2 {
      transition: transform 0.5s;
    }

    .signup_form {
      transition: transform 0.5s;
    }

    .signup_form2.right-panel {
      transform: translateX(100%);
      border-radius: 0 12px 12px 0;
    }

    .signup_form.left-panel {
      transform: translateX(-100%);
      border-radius: 15px 0 0 15px;

    }

    @media (max-width: 600px) {

      .profile_side,
      .signup_form2,
      .signup_form {
        transition: transform 0.5s;
      }

      .signup_form2.right-panel {
        transform: translateY(-100%);
      }

      .signup_form.left-panel {
        transform: translateY(100%);
      }
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
            <a href="index.php" class="back_btn"><i class="icofont-arrow-left"></i> Înapoi acasă</a>
          </div>

          <div class="profile_block">
            <div id="profile_block" class="profile_side">
              <div class="top_side">
                <a href="index.php"><img src="images/new/Logo.png" alt="image" style="margin-bottom:15px;"></a>
                <p>Federația Patronatelor din Industriile Creative este reprezentată la nivelul Consiliului de Export
                  al
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
                <h2>Înscrie-te gratuit</h2>
                <p>Completează toate câmpurile <br>pentru a obține informațiile necesare înregistrării.</p>
              </div>
              <div class="section_form">
                <form id="sign_up_form" method="post">

                  <div class="form-group">
                    <input type="text" name="nume" id="nume" class="form-control" placeholder="Nume">
                    <?php if (isset($errors["nume"])) { ?>
                      <p class="error">
                        <?php echo $errors["nume"]; ?>
                      </p>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <input type="text" name="prenume" id="prenume" class="form-control" placeholder="Prenume">
                    <?php if (isset($errors["prenume"])) { ?>
                      <p class="error">
                        <?php echo $errors["prenume"]; ?>
                      </p>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                    <?php if (isset($errors["email"])) { ?>
                      <p class="error">
                        <?php echo $errors["email"]; ?>
                      </p>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <input type="password" name="parola" id="password" class="form-control" placeholder="Parolă">
                    <?php if (isset($errors["password"])) { ?>
                      <p class="error">
                        <?php echo $errors["password"]; ?>
                      </p>
                    <?php } ?>
                  </div>

                  <div class="form-group text-center">
                    <div class="container px-4">
                      <div class="row gx-5">
                        <div class="col">
                          <input class="form-check-input" type="radio" name="person" id="flexRadioDefault1"
                            value="Fizică" checked>
                          <label class="form-check-label" for="flexRadioDefault1">
                            Persoană fizică
                          </label>
                        </div>
                        <div class="col">
                          <input class="form-check-input" type="radio" name="person" id="flexRadioDefault2"
                            value="Juridică">
                          <label class="form-check-label" for="flexRadioDefault2">
                            Persoană juridică
                          </label>
                        </div>
                      </div>
                    </div>
                    <?php if (isset($errors["person"])) { ?>
                      <p class="error">
                        <?php echo $errors["person"]; ?>
                      </p>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <button class="btn btn_main" type="submit" name="inregistrare">ÎNSCRIE-TE <i
                        class="icofont-arrow-right"></i></button>
                    <div id="success_message" class="correct" style="display:none;"></div>
                  </div>
                </form>

              </div>
              <p class="or_block">
                <span>SAU</span>
              </p>
              <div class="or_option">
                <p>Înscrie-te cu adresa de email</p>
                <a href="#" class="btn google_btn"><img src="images/google.png" alt="image"> <span>Sign Up with
                    Google</span> </a>
                <p>Ai deja cont? <a href="sign-in">Autentifică-te</a></p>
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
    const fizicaRadio = document.getElementById("flexRadioDefault1");
    const juridicaRadio = document.getElementById("flexRadioDefault2");
    const profileBlock = document.getElementById("profile_block");
    const originalContent = profileBlock.innerHTML;
    const mainForm = document.querySelector("form");
    const profileSide = document.querySelector(".profile_side");
    const signupForm = document.querySelector(".signup_form");

    fizicaRadio.addEventListener("change", function () {
      if (fizicaRadio.checked) {
        profileBlock.innerHTML = originalContent;
        profileBlock.classList.remove("signup_form2");
        profileBlock.classList.add("profile_side");
        profileBlock.classList.remove("right-panel");
        signupForm.classList.remove("left-panel");
      }
    });

    juridicaRadio.addEventListener("change", function () {
      if (juridicaRadio.checked) {
        profileBlock.innerHTML = `
      <div class="section_title">
        <h2 style="color:white;">Detalii Firmă</h2>
        <p>Toate câmpurile marcate cu * sunt obligatorii.<br>Informațiile sunt protejate conform regulamentului GDPR.</p>
      </div>
      <div class="section_form">
        <div class="form-group">
          <input type="text" class="form-control" id="nume_firma" name="nume_firma_input" placeholder="Nume Firmă*" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="rol_firma" name="rol_firma_input" placeholder="Rolul ocupat în firmă*" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="cui" name="cui_input" placeholder="CUI*" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="coduri_caen" name="coduri_caen_input" placeholder="Coduri Caen*" required>
        </div>
      </div>
    `;
        profileBlock.classList.remove("profile_side");
        profileBlock.classList.add("signup_form2");
        profileBlock.classList.add("right-panel");
        signupForm.classList.add("left-panel");
      }
    });

    mainForm.addEventListener("submit", function (event) {
      const secondaryForm = document.querySelector(".signup_form2 .section_form");
      if (secondaryForm) {
        const secondaryFormInputs = secondaryForm.querySelectorAll("input");
        secondaryFormInputs.forEach(function (input) {
          const inputClone = input.cloneNode(true);
          inputClone.type = "hidden";
          inputClone.name = input.name.replace("_input", "");
          mainForm.appendChild(inputClone);
        });
      }
    });
  </script>
  <script>
    document.getElementById('sign_up_form').addEventListener('submit', function (event) {
      event.preventDefault();
      var formData = new FormData(this);
      var xhr = new XMLHttpRequest();

      xhr.open('POST', 'php/session/sign_up_send.php', true);

      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 400) {
          var response = JSON.parse(xhr.responseText);
          console.log(xhr.responseText);

          if (response.hasOwnProperty('success')) {
            var errorElements = document.querySelectorAll('.error');
            errorElements.forEach(function (element) {
              element.parentNode.removeChild(element);
            });

            var successMessage = document.getElementById('success_message');
            successMessage.innerHTML = response.success;
            successMessage.style.display = 'block';
          }
          else if (response.hasOwnProperty('errors')) {
            var errorElements = document.querySelectorAll('.error');
            errorElements.forEach(function (element) {
              element.parentNode.removeChild(element);
            });

            for (var field in response.errors) {
              if (response.errors.hasOwnProperty(field)) {
                var errorMessage = response.errors[field];
                var errorElement = document.createElement('p');
                errorElement.className = 'error';
                errorElement.textContent = errorMessage;

                var formField = document.getElementById(field);
                formField.parentNode.insertBefore(errorElement, formField.nextSibling);
              }
            }
          } else {
            console.error('Invalid response format');
          }
        } else {
          console.error('Request failed');
        }
      };


      xhr.send(formData);
    });
  </script>

</body>


</html>