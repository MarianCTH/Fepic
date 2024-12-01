<?php
require_once '../config/config.php';
require_once 'php/config/config-admin.php';


session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}
$current_page = "Events";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        #users-signup-list,
        #event-list {
            margin-top: 1rem !important;
        }

        #datepicker,
        #datepicker2,
        #time-picker,
        #time-picker2,
        #date-pick1,
        #date-pick2,
        #time-pick1,
        #time-pick2 {
            z-index: 10000;
        }

        .dz-success-mark,
        .dz-error-mark,
        .dz-error-message {
            display: none !important;
        }
    </style>
</head>

<body class="layout-light side-menu">
    <div class="mobile-author-actions"></div>
    <?php require_once $config_file . 'header.php'; ?>
    <main class="main-content">
        <?php require_once $config_file . 'sidebar.php'; ?>
        <div class="contents">
            <div class="dm-page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-main">
                                <h4 class="text-capitalize breadcrumb-title">calendar evenimente</h4>
                                <div class="breadcrumb-action justify-content-center flex-wrap">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#"><i
                                                        class="uil uil-estate"></i>Acasă</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                <?php echo $current_page; ?>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row calendar-grid justify-content-center">
                        <div class="col-xxl-3 col-xl-5 col-md-6 col-sm-8">
                            <div class="dm-calendar-left">
                                <button class="btn btn-primary btn-lg btn-create-event" data-bs-toggle="modal"
                                    data-bs-target="#c-event-modal">
                                    <img class="svg" src="img/svg/plus.svg" alt>Creează eveniment nou</button>
                                <div class="card card-md mb-4">
                                    <div class="card-body">
                                        <div>
                                            <div class="d-flex justify-content-between">
                                                <h6>Ultimii utilizatori înscriși</h6>
                                            </div>
                                            <ul id="users-signup-list">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-md mb-4">
                                    <div class="card-body">
                                        <div>
                                            <div class="d-flex justify-content-between">
                                                <h6>Ultimele evenimente</h6>
                                            </div>
                                            <ul id="event-list">
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xxl-9 col-xl-7">
                            <div class="card card-default card-md mb-4">
                                <div class="card-body">
                                    <div id="full-calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Ok</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="c-event-modal modal fade" id="c-event-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-md c-event-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title">Eveniment</h6>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <img src="img/svg/x.svg" alt="x" class="svg">
                            </button>
                        </div>
                        <form action="" id="create-event">

                            <div class="modal-body">
                                <div class="c-event-form">
                                    <div class="e-form-row d-flex">
                                        <div class="e-form-row__left">
                                            <label>Titlu *</label>
                                        </div>
                                        <div class="e-form-row__right">
                                            <input type="text" name="e-title" placeholder="titlu"
                                                class="form-control form-control-md">
                                        </div>
                                    </div>

                                    <div class="e-form-row d-flex">
                                        <div class="e-form-row__left">
                                            <label>Tip de eveniment *</label>
                                        </div>
                                        <div class="e-form-row__right">
                                            <div class="radio-horizontal-list d-flex flex-wrap">
                                                <div class="radio-theme-default custom-radio ">
                                                    <input class="radio" type="radio" name="radio-e-type" value="01"
                                                        id="radio-1" checked>
                                                    <label for="radio-1">
                                                        <span class="radio-text">Târg</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="e-form-row d-flex">
                                        <div class="e-form-row__left">
                                            <label>Data de începere *</label>
                                        </div>
                                        <div class="e-form-row__right d-flex">
                                            <div class="input-container icon-left position-relative me-2">
                                                <span class="input-icon icon-left">
                                                    <img class="svg" src="img/svg/chevron-right.svg"
                                                        alt="chevron-right.svg">
                                                </span>
                                                <input type="text" class="form-control form-control-md" name="s-date"
                                                    id="date-pick1" placeholder="Dată">
                                            </div>
                                            <div class="input-container icon-left position-relative">
                                                <span class="input-icon icon-left">
                                                    <img class="svg" src="img/svg/clock.svg" alt="clock">
                                                </span>
                                                <input type="text" class="form-control form-control-md" name="s-time"
                                                    id="time-pick1" placeholder="Timp">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="e-form-row d-flex">
                                        <div class="e-form-row__left">
                                            <label>Dată de terminare *</label>
                                        </div>
                                        <div class="e-form-row__right d-flex">
                                            <div class="input-container icon-left position-relative me-2">
                                                <span class="input-icon icon-left">
                                                    <img class="svg" src="img/svg/chevron-right.svg"
                                                        alt="chevron-right.svg">
                                                </span>
                                                <input type="text" class="form-control form-control-md" name="e-date"
                                                    id="date-pick2" placeholder="Dată">
                                            </div>
                                            <div class="input-container icon-left position-relative">
                                                <span class="input-icon icon-left">
                                                    <img class="svg" src="img/svg/clock.svg" alt="clock">
                                                </span>
                                                <input type="text" class="form-control form-control-md" name="e-time"
                                                    id="time-pick2" placeholder="Timp">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="e-form-row d-flex">
                                        <div class="e-form-row__left">
                                            <label>Descriere</label>
                                        </div>
                                        <div class="e-form-row__right">
                                            <textarea name="e-description" class="form-control form-control-md"
                                                name="e-description" placeholder="Adaugă descriere..."></textarea>
                                        </div>
                                    </div>

                                    <div class="e-form-row d-flex">
                                        <div class="e-form-row__left">
                                            <label>Link Articol</label>
                                        </div>
                                        <div class="e-form-row__right">
                                            <input type="text" name="e-article-link" placeholder="link"
                                                class="form-control form-control-md">
                                        </div>
                                    </div>
                                    <div class="e-form-row d-flex" id="error-create-event-div">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white btn-sm"
                                    data-bs-dismiss="modal">Anulează</button>
                                <button type="submit" class="btn btn-primary btn-sm">Crează</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="e-info-modal modal fade" id="e-info-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm e-info-dialog modal-dialog-centered" id="c-event" role="document">
                    <div class="modal-content">
                        <div class="modal-header e-info-header bg-primary">
                            <h6 class="modal-title e-info-title">Project Update</h6>
                            <div class="e-info-action">
                                <button class="btn-icon" id="edit">
                                    <img class="svg" src="img/svg/edit.svg" alt="edit">
                                </button>
                                <button class="btn-icon" id="signedup_users">
                                    <img class="svg" src="img/svg/user.svg" alt="mail">
                                </button>
                                <button class="btn-icon" id="send-notif">
                                    <img class="svg" src="img/svg/mail.svg" alt="mail">
                                </button>
                                <button class="btn-icon" id="delete">
                                    <img class="svg" src="img/svg/trash-2.svg" alt="trash">
                                </button>
                                <button type="button" class="btn-icon btn-closed" data-bs-dismiss="modal" id = "close-event-modal"
                                    aria-label="Close">
                                    <i class="uil uil-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <ul class="e-info-list">
                                <li>
                                    <img class="svg" src="img/svg/chevron-right.svg" alt="chevron-right.svg">
                                    <span class="list-line">
                                        <span class="list-label"></span>
                                        <span class="list-meta"></span>
                                    </span>
                                </li>
                                <li>
                                    <img class="svg" src="img/svg/clock.svg" alt="clock">
                                    <span class="list-line">
                                        <span class="list-label"></span>
                                        <span class="list-meta"> </span>
                                    </span>
                                </li>
                                <li>
                                    <img class="svg" src="img/svg/align-left.svg" alt="align-left">
                                    <span class="list-line">
                                        <span class="list-text"></span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-basic modal fade show" id="info-modal" tabindex="-2" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content modal-bg-white ">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-info-title"></h6>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <img src="img/svg/x.svg" alt="x" class="svg">
                            </button>
                        </div>
                        <div class="modal-body" id="modal-info-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-sm" id="confirm-modal">Sigur</button>
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Anulează</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once $config_file . 'footer.php'; ?>
    </main>
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
        var currentDate = new Date();
        var day = currentDate.getDate().toString().padStart(2, '0');
        var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
        var year = currentDate.getFullYear();

        var formattedDate = day + '/' + month + '/' + year;

        document.getElementById('date-pick1').value = formattedDate;
        document.getElementById('date-pick2').value = formattedDate;

        $("#date-pick1, #date-pick2").datepicker({
            dateFormat: "d/mm/yy",
            duration: "medium",
            changeMonth: true,
            changeYear: true,
            yearRange: "2010:2059"
        });
        $("#time-pick1, #time-pick2").wickedpicker({
            twentyFour: true,
            timeSeparator: ':'
        });


    </script>
</body>

</html>