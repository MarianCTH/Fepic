<?php
include('config/config.php');
$error = "";

if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"] == "reset") && !isset($_POST["action"])) {
    $key = $_GET["key"];
    $email = $_GET["email"];
    $curDate = date("Y-m-d H:i:s");
    $query = mysqli_query($db, "SELECT * FROM `password_reset_temp` WHERE `key`='" . $key . "' and `email`='" . $email . "';");
    $row = mysqli_num_rows($query);
    if ($row == "") {
        $error = '<h2>Link invalid</h2>
            <p>Linkul este invalid/expirat. Fie nu ai copiat linkul corect
            din e-mail, sau ați folosit deja cheia, caz în care este
            dezactivat.</p>
            <p><a href="forgot-password.php">
            Apasă aici pentru</a> resetarea parolei.</p>';
    } else {
        $row = mysqli_fetch_assoc($query);
        $expDate = $row['expDate'];
        if ($expDate >= $curDate) { ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Fepic - Resetare parolă</title>
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
                                            <a href="index.html"><img src="images/new/Logo.png" alt="image"
                                                    style="margin-bottom:15px;"></a>
                                            <p>Federația Patronatelor din Industriile Creative este reprezentată la nivelul
                                                Consiliului de Export al României. Patronatele individual, dar şi Federația, sunt
                                                afiliate Uniunii Generale a Industriașilor din România şi au astfel
                                                reprezentativitate naţională conform legii patronatelor.</p>
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
                                            <p>Ați uitat parola?<br>Introduceți mai jos adresa dumneavoastră de e-mail pentru a
                                                începe procesul de regenerare.</p>
                                        </div>
                                        <div class="section_form">
                                            <form method="post" action="" name="update">
                                                <div class="form-group">
                                                    <input type="hidden" name="action" value="update" />
                                                    <br /><br />
                                                    <label><strong>Introdu parola nouă:</strong></label><br />
                                                    <input type="password" class="form-control" name="pass1" maxlength="15"
                                                        required />
                                                    <br /><br />
                                                    <label><strong>Reintrodu parola:</strong></label><br />
                                                    <input type="password" class="form-control" name="pass2" maxlength="15"
                                                        required />
                                                    <br />
                                                    <input type="hidden" class="form-control" name="email"
                                                        value="<?php echo $email; ?>" />
                                                    <button class="btn btn_main" type="submit" name="update">Trimite<i
                                                            class="icofont-arrow-right"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <p class="or_block">
                                            <span></span>
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

            </body>


            </html>
            <?php
        } else {
            $error .= "<h2>Link expirat</h2>
                <p>Link-ul a expirat. Încercați să utilizați alt link !
                Valabil doar 24 de ore (1 zi de la cerere).<br /><br /></p>";
        }
    }

}

if ($error != "") {
    echo "<div class='error'>" . $error . "</div><br />";
}

if (isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"] == "update")) {
    $error = "";
    $pass1 = mysqli_real_escape_string($db, $_POST["pass1"]);
    $pass2 = mysqli_real_escape_string($db, $_POST["pass2"]);
    $email = $_POST["email"];
    $curDate = date("Y-m-d H:i:s");
    if ($pass1 != $pass2) {
        $error .= "<p>Parola nu se potrivește, ambele parole ar trebui să fie aceeași.<br /><br /></p>";
    }
    if ($error != "") {
        echo "<div class='error'>" . $error . "</div><br />";
    } else {
        $pass1 = md5($pass1);
        mysqli_query(
            $db,
            "UPDATE `utilizatori` SET `Parola`='" . $pass1 . "' WHERE `Email`='" . $email . "';"
        );

        mysqli_query($db, "DELETE FROM `password_reset_temp` WHERE `email`='" . $email . "';");

        echo '<div class="error"><p>Felicitări! Parola dvs. a fost actualizată cu succes.</p>
        <p><a href="sign-in.php">
        Apasă aici pentru </a>autentificare.</p></div><br />';
    }
}
?>