<?php
include_once("config/config.php");
header("Content-type: text/html; charset=UTF-8");
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Federatia Patronatelor din Industriile Creative: FEPIC
  </title>
  <script defer src="https://europa.eu/webtools/load.js" type="text/javascript"></script>

  <link rel="stylesheet" href="css/icofont.min.css">
  <link rel="stylesheet" href="css/animate.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="css/modal.css">

  <script src="js/jquery.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

</head>

<body>
  <div class="page_wrapper">

    <div id="preloader">
      <div class="circle-border">
        <div class="circle-core"></div>
      </div>
    </div>

    <div class="top_home_wraper">
      <div class="banner_shapes">
        <div class="container">
          <span><img src="images/new/plus.svg" alt="image"></span>
          <span><img src="images/new/polygon.svg" alt="image"></span>
          <span><img src="images/new/round.svg" alt="image"></span>
        </div>
      </div>

      <?php include 'config/header.php'; ?>

      <section class="banner_section">
        <div class="container">
          <div class="banner_text">
            <div class="ban_inner_text" data-aos="fade-up" data-aos-duration="1500">
              <span>Alătură-te comunității noastre </span>
              <h1>Federatia Patronatelor <br>din Industriile Creative</h1>
              <p>Singura federație patronală reprezentativă la nivel național</p>
            </div>
            <form id="subscriptionForm" method="post" data-aos="fade-up" data-aos-duration="1500">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Introduceți email-ul" id="email" name="email"
                  required>
                <button class="btn btn_main" type="submit">Abonează-te <i class="icofont-arrow-right"></i></button>
              </div>
              <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
              } else { ?>
                <span>Ai deja cont? <a href="sign-in">Conectează-te</a></span>
              <?php } ?>
            </form>
          </div>
          <div class="banner_images" data-aos="fade-up" data-aos-duration="1500">
            <img src="images/new/banner_01.png" alt="image">
            <div class="sub_images">
              <img class="moving_animation" style="display:none;" src="images/new/banner_02.png" alt="image">
              <img class="moving_animation" src="images/new/banner_03.png" alt="image">
              <img class="moving_animation" src="images/new/banner_04.png" alt="image">
            </div>
          </div>
        </div>
      </section>

    </div>

    <section class="row_am collaborate_section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="collaborate_image" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
              <div class="img_block" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
                <img class="icon_img moving_animation" src="images/new/Collaborate-icon_1.png" alt="image">
                <img src="images/new/Collaborate-01.png" alt="image">
              </div>
              <div class="img_block" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
                <img src="images/new/Collaborate-02.png" alt="image">
                <img class="icon_img moving_animation" src="images/new/Collaborate-icon_2.png" alt="image">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="collaborate_text" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
              <span class="icon"><img src="images/new/securely.svg" alt="image"></span>
              <div class="section_title">
                <h2>Colaborare</h2>
                <p>Federatia Patronatelor din Industriile Creative din Romania vă pune la dispoziție o platformă pentru
                  a vă gestiona mai ușor activitatea.</p>
              </div>

              <ul>
                <li data-aos="fade-up" data-aos-duration="2000">
                  <h3>Sincronizarea statisticilor</h3>
                  <p>Prin intermediul nostru, veți avea posibilitatea de a sincroniza și monitoriza statisticile
                    esențiale ale
                    activității dvs.</p>
                </li>
                <li data-aos="fade-up" data-aos-duration="2000">
                  <h3>Conectivitate globală</h3>
                  <p>Prin integrarea tuturor platformelor relevante, vă oferim o soluție completă de gestionare a
                    prezenței online.</p>
                </li>
              </ul>
              <a href="colaborare" data-aos="fade-up" data-aos-duration="2000" class="btn btn_main">CITEȘTE MAI MULT
                <i class="icofont-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="row_am trusted_section">
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
          <h2>Membrii federației</h2>
          <p>Federaţia Patronatelor din Industriile Creative</p>
        </div>

        <div class="company_logos" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
          <div id="company_slider" class="owl-carousel owl-theme">
            <div class="item">
              <div class="logo">
                <img src="images/membri/zapp-banner.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="images/membri/apic-banner.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="images/membri/fit-banner.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="images/membri/rama-banner.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="images/membri/crfm-banner.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="images/membri/upfr-banner.png" alt="image">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="row_am pricing_section our_team_section" id="pricing" data-aos="fade-in" data-aos-duration="1000">
      <div class="dotes_anim_bloack">
        <div class="dots dotes_1"></div>
        <div class="dots dotes_2"></div>
        <div class="dots dotes_3"></div>
        <div class="dots dotes_4"></div>
        <div class="dots dotes_5"></div>
        <div class="dots dotes_6"></div>
        <div class="dots dotes_7"></div>
        <div class="dots dotes_8"></div>
      </div>
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
          <h2>Echipa FEPIC</h2>
          <p>Echipa responsabilă pentru dezvoltarea Federatiei Patronatelor din Industriile Creative</p>
        </div>
        <div class="team_block" style="padding-bottom: 11rem;">
          <div class="row">
            <?php include 'config/team.php'; ?>
          </div>
        </div>

      </div>
    </section>

    <section class="need_section" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
      <?php include 'config/support.php' ?>
    </section>

    <section class="row_am latest_story" id="blog">
      <div class="container">
        <div class="section_title" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
          <h2>Citește ultimele <span>noutăți</span></h2>
          <p>Fii la curent cu tot ce se întâmplă pe comunitatea FEPIC.</p>
        </div>
        <div class="row">
          <?php
          $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
          $db->set_charset("utf8mb4");

          if ($db === false) {
            die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
          }
          $query = "SELECT blog.*, utilizatori.*
          FROM blog
          JOIN utilizatori ON blog.ID_autor = utilizatori.ID
          ORDER BY blog.Data DESC
          LIMIT 3";

          $result = mysqli_query($db, $query);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
              $text = $row["Text"];
              $limitedText = substr($text, 0, 90);

              if (strlen($text) > 90) {
                $limitedText .= "...";
              }

              $date = date_create($row["Data"]);
              $day = date_format($date, "j");
              $month = date_format($date, "M");

              $postID = $row["Nr_articol"];
              $commentsQuery = "SELECT COUNT(*) AS commentCount FROM comentarii_postare WHERE ID_postare = $postID";
              $commentsResult = mysqli_query($db, $commentsQuery);
              $commentCount = mysqli_fetch_assoc($commentsResult)["commentCount"];
              ?>
              <div class="col-md-4">
                <div class="story_box" data-aos="fade-up" data-aos-duration="1500">
                  <div class="story_img">
                    <img src="images/blog/<?php echo $row["Image"]; ?>" alt="image">
                    <span><span>
                        <?php echo $day; ?>
                      </span>
                      <?php echo $month; ?>
                    </span>
                  </div>
                  <div class="story_text">
                    <div class="statstic">
                      <span><i class="icofont-user-suited"></i>
                        <?php echo $row['Nume'] . ' ' . $row['Prenume']; ?>
                      </span>
                      <span><i class="icofont-speech-comments"></i>
                        <?php echo $commentCount;
                        if ($commentCount == 1)
                          echo ' Comentariu';
                        else
                          echo ' Comentarii'; ?>
                      </span>
                    </div>
                    <h3>
                      <?php echo $row["Subiect"]; ?>
                    </h3>
                    <p>
                      <?php echo $limitedText; ?>
                    </p>
                    <a href="<?php echo $row["permalink"]; ?>" class="btn text_btn">Citește mai mult <i
                        class="icofont-arrow-right"></i></a>
                  </div>
                </div>
              </div>
              <?php
            }
          }
          ?>
        </div>
      </div>
    </section>

    <?php include 'config/footer.php' ?>

  </div>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <script>
    $(document).ready(function () {
      $('#subscriptionForm').submit(function (e) {
        e.preventDefault();

        var email = $('#email').val();

        $.ajax({
          type: 'POST',
          url: 'php/notifications/subscribe.php',
          data: { email: email },
          success: function (response) {
            $('#modal-info-success-sub .modal-info-text p').text(response);
            $('#modal-info-success-sub').modal('show');
          }
        });
      });
    });
  </script>

</body>

</html>