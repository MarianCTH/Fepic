<?php 
if( empty(session_id()) && !headers_sent()){
    session_start();
}
require_once 'php/notificari.php'; ?>
<header class="fixed">
  <div class="container">
    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand" href="index">
        <img src="images/new/Logo.png" alt="image">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
          <span class="toggle-wrap">
            <span class="toggle-bar"></span>
          </span>
        </span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item active">
            <a class="nav-link" href="index">Acasă</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="team">Echipă</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="membri">Membri</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="evenimente">Evenimente</a>
          </li>

          <li class="nav-item has_dropdown">
            <a class="nav-link" href="noutati">Noutăți</a>
            <span class="drp_btn"><i class="icofont-rounded-down"></i></span>
            <div class="sub_menu">
              <ul>
                <?php
                include_once("config/config.php");
                $query = "SELECT * FROM blog ORDER BY Data DESC LIMIT 4";
                $result = mysqli_query($db, $query);
                $output = '';
                if (mysqli_num_rows($result) > 0) {
                  $text = "";
                  while ($row = mysqli_fetch_array($result)) {
                    if (strlen($row["Subiect"]) > 23) {
                      $text = substr($row["Subiect"], 0, 19);
                      $text .= '...';
                      echo '<li><a href="'. $row["permalink"]. '">' . $text . '</a></li>';
                    } else
                      echo '<li><a href="'. $row["permalink"]. '">' . $row["Subiect"] . '</a></li>';
                  }
                }
                $db->close();
                ?>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="faq">FAQ</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="contact" style="margin-right: 20px;">Contact</a>
          </li>
          <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>


            <li class="nav-item has_dropdown2">
              <a class="nav-link dark_btnlogged" href="#">Salut,
                <?php echo $_SESSION["username"]; ?> !
              </a>
              <div class="sub_menu">
                <ul>
                  <li><a href="profile"><i class="icofont-user-alt-7"></i> Profil</a></li>
                  <?php if ($_SESSION["rol"] == 'Administrator')
                    echo '<li ><a href="admin/index.php"><i class="icofont-shield"></i> Administrare</a></li>'; ?>
                  <li><a href="sign-out.php"><i class="icofont-sign-out"></i> Sign out</a></li>
                </ul>
              </div>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link dark_btn" href="sign-up">Inregistrare <i class="icofont-arrow-right"></i></a>
            </li>
          <?php } ?>

        </ul>
      </div>
    </nav>
  </div>
</header>