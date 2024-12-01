<!DOCTYPE html>
<html lang="en">
<?php include_once 'config/config.php'; ?>

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Echipa
    <?php echo $nume ?>
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
            <h2>Echipa FEPIC</h2>
            <ul>
              <li><a href="index">Acasă</a></li>
              <li><span>»</span></li>
              <li><a href="team">Echipă</a></li>
            </ul>
          </div>
        </div>
      </div>

    </div>


    <section class="about_us_page_section">
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
        <div class="about_block">
          <div class="row">
            <div class="col-md-6">
              <div class="section_title" data-aos="fade-in" data-aos-duration="1500">
                <h2>Câteva cuvinte despre noi</h2>
                <p>Federația Patronatelor din Industriile Creative este reprezentată la nivelul Consiliului de Export al
                  României. Patronatele individual, dar şi Federația, sunt afiliate Uniunii Generale a Industriașilor
                  din România şi au astfel reprezentativitate naţională conform legii patronatelor. În paralel,
                  patronatele şi/sau federaţia sunt afiliate sau în curs de afiliere la organismele naționale și
                  europene în domeniu (ANEIR, Innovation Network Europe, European Creative Initiative etc.)</p>

              </div>
            </div>
            <div class="col-md-6">
              <div class="abt_img_block" data-aos="fade-in" data-aos-duration="1500">
                <a data-aos="fade-up" data-aos-duration="1500" class="popup-youtube play-button"
                  data-url="" data-toggle="modal"
                  data-target="#myModal" title="XJj2PbenIsU">
                  <div class="play_btn">
                    <img src="images/new/orange_play.png" alt="image">
                    <div class="waves-block">
                      <div class="waves wave-1"></div>
                      <div class="waves wave-2"></div>
                      <div class="waves wave-3"></div>
                    </div>
                  </div>
                </a>
                <div class="top_img">
                  <img src="images/new/abt_01.png" alt="image">
                  <img src="images/new/abt_02.png" alt="image">
                </div>
                <div class="bottom_img">
                  <img src="images/new/abt_03.png" alt="image">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <section class="row_am our_team_section">
    <div class="container">
      <div class="section_title" data-aos="fade-up" data-aos-duration="1500">
        <h2>Echipa FEPIC</h2>
      </div>
      <div class="team_block">
        <div class="row">
          <?php include 'config/team.php'; ?>
        </div>
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


</body>

</html>