<!DOCTYPE html>
<html lang="en">
<?php
include_once("config/config.php");
header("Content-type: text/html; charset=UTF-8");
?>

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php echo $nume ?> - Colaborare
  </title>

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

      <?php include 'config/header.php'; ?>

      <div class="bread_crumb" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
        <div class="container">
          <div class="bred_text">
            <h2>Colaborează cu
              <?php echo $nume ?>
            </h2>
            <ul>
              <li><a href="index.php">Acasă</a></li>
              <li><span>»</span></li>
              <li><a href="colaborare.php">Colaborare</a></li>
            </ul>
          </div>
        </div>
      </div>

    </div>

    <section class="service_detail_section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="service_left_side">
              <div class="section_title" data-aos="fade-up" data-aos-duration="2000">
                <h2>Dorești să colaborezi cu noi?</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum has been the
                  industrys standard dummy text ever since the when an unknown printer took a galley of type and.
                  scrambled it to make a type specimen book.</p>
              </div>
              <div class="img" data-aos="fade-up" data-aos-duration="2000">
                <img src="images/new/service-img.png" alt="image">
              </div>
              <h3 data-aos="fade-up" data-aos-duration="1500">Beneficiile de a colabora cu noi</h3>
              <p data-aos="fade-up" data-aos-duration="1500">Lorem Ipsum is simply dummy text of the printing and
                typesetting industry lorem Ipsum has been the
                industrys standard dummy text ever since the when an utext ever since the when an unknown printer took a
                galley of type and. scrambled it to make a type speci
                men book It has survived not only five centuries, but also the leap into electronic type
                setting, remaining essentially unchanged.
              </p>
              <ul class="list_block" data-aos="fade-up" data-aos-duration="1500">
                <li>
                  <h3>Carefully designed</h3>
                  <p>Lorem Ipsum is simply dummy text of the printing and typ esetting industry lorem Ipsum has.</p>
                </li>
                <li>
                  <h3>24/7 live support</h3>
                  <p>Lorem Ipsum is simply dummy text of the printing and typ esetting industry lorem Ipsum has.</p>
                </li>
                <li>
                  <h3>Expert developer</h3>
                  <p>Simply dummy text of the printing and typesetting inustry lorem Ipsum has Lorem dollar summit.</p>
                </li>
                <li>
                  <h3>Ontime delivery</h3>
                  <p>Simply dummy text of the printing and typesetting inustry lorem Ipsum has Lorem dollar summit.</p>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="service_right_side">
              <div class="side_contact_block" data-aos="fade-up" data-aos-duration="1500">
                <div class="icon"><i class="icofont-live-support"></i></div>
                <h3>Haide să lucrăm împreună</h3>
                <a href="contact.php" class="btn btn_main">CONTACTEAZĂ-NE <i class="icofont-arrow-right"></i></a>
                <p><a href="tel:+4 0722 690 504"><i class="icofont-phone-circle"></i> +4 0722 690 504</a></p>
              </div>
              <div class="action_btn">
                <a href="images/pdf-fepic.pdf" target="blank" class="btn" data-aos="fade-up"
                  data-aos-duration="1500">
                  <span><i class="icofont-file-pdf"></i> </span>
                  <p>Profilul Organizației</p>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="need_section innerpage_needsection" data-aos="fade-in" data-aos-duration="1500"
      data-aos-delay="100">
      <?php include 'config/support.php' ?>
    </section>

    <?php include 'config/footer.php' ?>

  </div>

  <script src="js/jquery.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>

</body>

</html>