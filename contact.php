<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact</title>

  <script defer src="https://europa.eu/webtools/load.js" type="text/javascript"></script>
  <link rel="stylesheet" href="css/icofont.min.css">
  <link rel="stylesheet" href="css/animate.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

</head>

<body>

  <div class="page_wrapper">

    <div id="preloader">
      <div class="circle-border">
        <div class="circle-core"></div>
      </div>
    </div>

    <div class="inner_page_block">

      <div class="banner_shapes">
        <div class="container">
          <span><img src="images/new/plus.svg" alt="image"></span>
          <span><img src="images/new/polygon.svg" alt="image"></span>
          <span><img src="images/new/round.svg" alt="image"></span>
        </div>
      </div>

      <?php
      include 'config/header.php';
      ?>
      <div class="bread_crumb" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
        <div class="container">
          <div class="bred_text">
            <h2>Contactați-ne</h2>
            <ul>
              <li><a href="index">Acasă</a></li>
              <li><span>»</span></li>
              <li><a href="contact">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>

    </div>

    <section class="row_am contact_list_section">
      <div class="container">

        <div class="contact_list_inner" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="100">

          <div class="c_list_card">
            <div class="icons">
              <img src="images/new/mail.png" alt="image">
              <div class="dot_block">
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
              </div>
            </div>
            <div class="inner_text">
              <h3>Email</h3>
              <p>Discută cu echipa noastră prin corespondență
              </p>
              <a href="mailto:office@fepic.ro" class="text_btn">office@fepic.ro</a>
            </div>
          </div>

          <div class="c_list_card">
            <div class="icons">
              <img src="images/new/location.png" alt="image">
              <div class="dot_block">
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
              </div>
            </div>
            <div class="inner_text">
              <h3>Birou</h3>
              <p>Ajungeți la noi la birou pentru a ne cunoaște
              </p>
              <a href="#" class="text_btn"> 34 Bucium Street, 700265, Romania </a>
            </div>
          </div>

          <div class="c_list_card">
            <div class="icons">
              <img src="images/new/phone.png" alt="image">
              <div class="dot_block">
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
              </div>
            </div>
            <div class="inner_text">
              <h3>Telefon</h3>
              <p>Luați legătura direct cu echipa prin telefonie
              </p>
              <a href="tel:+4 0722 690 504" class="text_btn">+4 0722 690 504</a>
            </div>
          </div>
        </div>

      </div>
    </section>

    <section class="contact_form_section" id="contact-form">
      <div class="container">
        <div class="contact_inner">
          <div class="contact_form">
            <div class="section_title">
              <h2>Lasă-ne un <span>mesaj</span></h2>
              <p>Completați formularul de mai jos, echipa noastră va răspunde în curând</p>
            </div>
            <form>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <?php
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                      $full_name = $_SESSION["username"] . ' ' . $_SESSION["prenume"];
                      $user_id = $_SESSION["id"];
                      $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                      $db->set_charset("utf8mb4");

                      if ($db === false) {
                        die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
                      }
                      $query = "SELECT Telefon FROM date_utilizatori WHERE ID_utilizator = ?";
                      $stmt = mysqli_prepare($db, $query);
                      mysqli_stmt_bind_param($stmt, "i", $user_id);
                      mysqli_stmt_execute($stmt);
                      mysqli_stmt_bind_result($stmt, $phone);
                      mysqli_stmt_fetch($stmt);

                      mysqli_stmt_close($stmt);
                    }
                    ?>
                    <input type="text" placeholder="Nume" class="form-control" name="name"
                      value="<?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
                        echo $full_name; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="email" placeholder="Email" class="form-control" name="email"
                      value="<?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
                        echo $_SESSION['email']; ?>">
                  </div>
                </div>
              </div>

              <div class="row">

                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" placeholder="Telefon" class="form-control" name="phone"
                      value="<?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
                        echo $phone; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <select class="form-control" name="city">
                      <option value="Alba Iulia">Alba Iulia</option>
                      <option value="Arad">Arad</option>
                      <option value="Argeș">Argeș</option>
                      <option value="Bacău">Bacău</option>
                      <option value="Bârlad">Bârlad</option>
                      <option value="Bistrița">Bistrița</option>
                      <option value="Botoșani">Botoșani</option>
                      <option value="Brașov">Brașov</option>
                      <option value="Brăila">Brăila</option>
                      <option value="București" selected>București</option>
                      <option value="Buftea">Buftea</option>
                      <option value="Buzău">Buzău</option>
                      <option value="Câmpina">Câmpina</option>
                      <option value="Câmpulung Moldovenesc">Câmpulung Moldovenesc</option>
                      <option value="Călărași">Călărași</option>
                      <option value="Cluj-Napoca">Cluj-Napoca</option>
                      <option value="Constanța">Constanța</option>
                      <option value="Craiova">Craiova</option>
                      <option value="Deva">Deva</option>
                      <option value="Drobeta-Turnu Severin">Drobeta-Turnu Severin</option>
                      <option value="Focșani">Focșani</option>
                      <option value="Galați">Galați</option>
                      <option value="Gheorgheni">Gheorgheni</option>
                      <option value="Giurgiu">Giurgiu</option>
                      <option value="Hunedoara">Hunedoara</option>
                      <option value="Iași">Iași</option>
                      <option value="Miercurea Ciuc">Miercurea Ciuc</option>
                      <option value="Oradea">Oradea</option>
                      <option value="Piatra Neamț">Piatra Neamț</option>
                      <option value="Pitești">Pitești</option>
                      <option value="Ploiești">Ploiești</option>
                      <option value="Râmnicu Vâlcea">Râmnicu Vâlcea</option>
                      <option value="Reșița">Reșița</option>
                      <option value="Satu Mare">Satu Mare</option>
                      <option value="Sibiu">Sibiu</option>
                      <option value="Sighișoara">Sighișoara</option>
                      <option value="Slatina">Slatina</option>
                      <option value="Suceava">Suceava</option>
                      <option value="Târgoviște">Târgoviște</option>
                      <option value="Târgu Jiu">Târgu Jiu</option>
                      <option value="Târgu Mureș">Târgu Mureș</option>
                      <option value="Timișoara">Timișoara</option>
                      <option value="Tulcea">Tulcea</option>
                      <option value="Turda">Turda</option>
                      <option value="Vaslui">Vaslui</option>
                      <option value="Zalău">Zalău</option>
                      <option value="Alt oraș">Alt oraș</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" placeholder="Subiect" class="form-control" name="subject">
              </div>
              <div class="form-group">
                <textarea class="form-control" placeholder="Mesajul tău" name="message"></textarea>
              </div>

              <div class="form-group term_check">
                <input type="checkbox" id="term" name="agree_terms">
                <label for="term">Sunt de acord să primesc e-mailuri, noutăți informative și mesaje promoționale</label>
              </div>

              <div class="form-group ">
                <button class="btn btn_main" type="submit" onclick="sendForm()">TRIMITE MESAJUL <i
                    class="icofont-arrow-right"></i></button>
              </div>
              <div id="result-message" style="text-align:center;"></div>
            </form>
            <div class="form-graphic">
              <img src="images/new/paperplane.png" alt="image">
            </div>
          </div>


        </div>
      </div>
    </section>

    <section class="row_am map_section">
      <div class="container">
        <div class="map_inner">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d36511.215468099785!2d27.596587661973533!3d47.14390175995471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40cafbc0617aba1f%3A0xb96fc512716fc6dd!2sStrada%20Bucium%2034%2C%20Ia%C8%99i!5e0!3m2!1sen!2sro!4v1684414212361!5m2!1sen!2sro"
            style="border:0; width: 100%; height: 510px;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </section>


    <?php include 'config/footer.php' ?>

  </div>

  <script src="js/jquery.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <script>
    function sendForm() {
      event.preventDefault();

      var formData = new FormData(document.querySelector('form'));

      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'php/contact/send_email.php', true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById('result-message').innerHTML = response.message;
          } else {
            document.getElementById('result-message').innerHTML = 'An error occurred.';
          }
        }
      };

      xhr.send(formData);
    }

    document.querySelector('form').addEventListener('submit', sendForm);

  </script>
</body>

</html>