<?php

require_once '../config/config.php';
require_once 'php/config/config-admin.php';
session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}
$current_page = "Mesaje";
if (empty($_GET['requestId'])) {
    header("Location: ../error.php");
    exit();
}
$request_id = $_GET['requestId'];
?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo $title . ' - ' . $current_page; ?>
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/plugin.min.css">
    <link rel="stylesheet" href="style.css">

    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#request-answer',
            height: 500,
            promotion: false,
            plugins: '',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ],
            menubar: false,
            branding: false,
        });
    </script>
    <style>
        .pfp {
            width: 50px;
            height: 50px;
            border-bottom-left-radius: 50%;
            border-bottom-right-radius: 50%;
            border-top-left-radius: 50%;
            border-top-right-radius: 50%;
        }
    </style>
</head>

<body class="layout-light side-menu">
    <div class="mobile-author-actions"></div>
    <?php require_once $config_file . 'header.php'; ?>
    <main class="main-content">
    <?php require_once $config_file . 'sidebar.php'; ?>
        <div class="contents">
            <div class="container-fluid">
                <div class="mailbox-wrapper">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="breadcrumb-main">
                                <h4 class="text-capitalize breadcrumb-title">Vizualizezi mesajul cu numărul
                                    <?php echo $request_id; ?>
                                </h4>
                                <div class="breadcrumb-action justify-content-center flex-wrap">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php"><i
                                                        class="uil uil-estate"></i>Acasă</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                <?php echo $current_page; ?>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                Vizualizare mesaj #
                                                <?php echo $request_id; ?>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <div class="mailbox-container mb-30">
                            <div class="mail-read-wrapper">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mail-read-content">
                                            <div class="col-lg-12">
                                                <div class="back-page">
                                                    <a href="requests"><img src="img/svg/arrow-left.svg"
                                                            alt="arrow-left" class="svg">
                                                        Înapoi</a>
                                                </div>
                                            </div>
                                            <div class="mail-details">
                                                <?php
                                                $query = "SELECT Nume, Email, Telefon, Oras, Titlu, Mesaj, Status, Data FROM cereri_contact WHERE ID_cerere = ?";
                                                $stmt = mysqli_prepare($db, $query);

                                                mysqli_stmt_bind_param($stmt, "i", $request_id);

                                                mysqli_stmt_execute($stmt);
                                                mysqli_stmt_bind_result($stmt, $name, $email, $phone, $city, $titlu, $message, $status, $data_crearii);
                                                mysqli_stmt_fetch($stmt);
                                                $formattedDate = date('M j, Y, g:i A', strtotime($data_crearii));
                                                mysqli_stmt_close($stmt);

                                                if ($status == 'Nou') {
                                                    $query = "UPDATE cereri_contact SET status = 'Deschis' WHERE ID_cerere = ?";
                                                    $stmt = mysqli_prepare($db, $query);
                                                    mysqli_stmt_bind_param($stmt, "i", $request_id);
                                                    mysqli_stmt_execute($stmt);
                                                    mysqli_stmt_close($stmt);

                                                }

                                                mysqli_close($db);
                                                ?>
                                                <div class="mail-details__top d-flex justify-content-between">
                                                    <h2 class="mail-details__title">
                                                        <span>
                                                            <?php echo $titlu; ?>
                                                        </span>
                                                        <span
                                                            class="badge badge-primary badge-transparent badge-round">Cerere
                                                            de contact</span>
                                                    </h2>
                                                </div>
                                                <div class="mail-details__content mdc media">
                                                    <div class="mdc__left">
                                                        <img src="../images/profile/default.png" alt="mail author">
                                                    </div>
                                                    <div class="mdc__right media-body">
                                                        <div class="mdc__head d-flex justify-content-between">
                                                            <div class="mdc__author media">
                                                                <div class="author-info">
                                                                    <h6>
                                                                        <?php echo $name; ?>
                                                                    </h6>
                                                                    <a class="mail-info-btn">Către administrație
                                                                        <img class="svg" src="img/svg/chevron-down.svg"
                                                                            alt="chevron-down">
                                                                        <ul class="mail-info">
                                                                            <li>
                                                                                <span
                                                                                    class="mail-info__label">spre:</span>
                                                                                <span class="mail-info__text"><span
                                                                                        class="__cf_email__"
                                                                                        data-cfemail="daa9bbb7aab6bf9abdb7bbb3b6f4b9b5b7"><?php echo $email; ?></span></span>
                                                                            </li>
                                                                            <li>
                                                                                <span class="mail-info__label">de
                                                                                    la:</span>
                                                                                <span class="mail-info__text"><span
                                                                                        class="__cf_email__"
                                                                                        data-cfemail="0774666a776b623547606a666e6b2964686a"><?php echo 'office@fepic.ro'; ?></span></span>
                                                                            </li>
                                                                            <li>
                                                                                <span
                                                                                    class="mail-info__label">data:</span>
                                                                                <span class="mail-info__text">
                                                                                    <?php echo $formattedDate; ?>
                                                                                </span>
                                                                            </li>
                                                                        </ul>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="mdc__excerpt">
                                                                <span class="date-meta">
                                                                    <?php echo $formattedDate; ?>
                                                                </span>
                                                                <a href="#">
                                                                    <img src="img/svg/star.svg" alt="star" class="svg">
                                                                </a>

                                                            </div>
                                                        </div>
                                                        <div class="mdc__body">
                                                            <p>
                                                                <?php echo $message; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mail-reply">
                                                <div class="mail-reply-box media">
                                                    <figure>
                                                        <img src="../images/profile/<?php echo $user['Poza']; ?>"
                                                            class="pfp" alt="Reply Author">
                                                    </figure>

                                                    <div class="mail-reply-inner media-body">
                                                        <form action="#" method="POST">
                                                            <div class="mailCompose-form-content">
                                                                <div class="form-group">
                                                                    <textarea name="content" id="request-answer"
                                                                        class="form-control-lg"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="reply-form__action d-flex justify-content-between align-items-center"
                                                                style="margin-top:1rem;">
                                                                <div class="reply-form__left d-flex align-items-center">
                                                                    <a id="send-answer"
                                                                        class="btn btn-md btn-primary btn-send">Trimite</a>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once $config_file . 'footer.php'; ?>
    </main>

    <div class="modal-info-success modal fade show" id="modal-info-success" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-info" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-info-body d-flex">
                        <div class="modal-info-icon success">
                            <img src="img/svg/check-circle.svg" alt="check-circle" class="svg">
                        </div>
                        <div class="modal-info-text">
                            <p>Mesajul a fost trimis cu succes (Actualizare în <span id="countdown">3</span> secunde)
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <div id="overlayer">
        <div class="loader-overlay">
            <div class="dm-spin-dots spin-lg">
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
            </div>
        </div>
    </div>
    <div class="overlay-dark-sidebar"></div>
    <div class="customizer-overlay"></div>
    <?php require_once $config_file . 'customizer-wrapper.php'; ?>
    <script src="js/plugins.min.js"></script>
    <script src="js/script.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#send-answer").on("click", function () {
                var editor = tinymce.get('request-answer');
                var content = editor.getContent();
                var email_to = "<?php echo $email; ?>";
                var name_to = "<?php echo $name; ?>";

                $.ajax({
                    url: "php/requests/contact_requests/send_request_response.php",
                    type: "POST",
                    data: {
                        content: content,
                        email_to: email_to,
                        name_to: name_to
                    },
                    success: function (response) {
                        $('#modal-info-success').modal('show');

                        var countdownValue = 4;
                        var countdownElement = $("#countdown");

                        function updateCountdown() {
                            countdownValue--;
                            countdownElement.text(countdownValue);
                            if (countdownValue <= 0) {
                                location.reload();
                            } else {
                                setTimeout(updateCountdown, 1000);
                            }
                        }

                        updateCountdown();
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>