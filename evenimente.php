<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenimente Fepic</title>

    <script defer src="https://europa.eu/webtools/load.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/icofont.min.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/modal.css">

    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

    <style>
        #targuri {
            text-align: center;
            padding: 20px;
        }

        .calendar-container {
            margin-top: 20px;
        }

        .calendar {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #6a49f2;
        }

        .calendar th,
        .calendar td {
            padding: 20px 28.2px;
            border: 1px solid #6a49f2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .calendar th {
            background-color: #6a49f2;
            color: white;
            font-weight: bold;
        }

        .calendar td {
            text-align: center;
        }

        .calendar-controls {
            margin-top: 10px;
        }

        .calendar-controls button {
            padding: 10px 20px;

            margin: 0 5px;
            font-size: 16px;
        }

        .prevButton,
        .nextButton {
            border-color: #6a49f2;
            background-image: none;
            color: #6a49f2;
        }

        .prevButton:hover,
        .nextButton:hover {
            background-image: none;
            color: #3f2999;
        }


        .starting-event-cell {
            background-color: #6a49f2;
            color: white;
            font-weight: bold;
        }

        .starting-event-cell:hover {
            background-color: #3f2999;
            border-color: #3f2999;
            color: white;
            font-weight: bold;
        }

        .image-container {
            max-width: 100%;
            max-height: 300px;
            margin: 0 auto;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: auto;
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
                        <h2>Evenimente</h2>
                        <ul>
                            <li><a href="index">Acasă</a></li>
                            <li><span>»</span></li>
                            <li><a href="targuri">Evenimente</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <section id="targuri" class="row_am service_detail_section" data-aos="fade-up" data-aos-duration="2000">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="service_left_side">
                            <h2 id="currentMonthDisplay"></h2>

                            <div class="calendar-container">
                                <div id='calendar'></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="service_right_side">
                            <div class="side_contact_block" data-aos="fade-up" data-aos-duration="1500">
                                <div class="icon"><i class="uil uil-calender"></i></div>

                                <h3>Următorul eveniment: <br><span class="h5" id="UrmatorulTarg"></span></h3>
                                <h3>Ultimul eveniment: <br><span class="h5" id="UltimulTarg"></span>
                                </h3>

                                <a href="contact" class="btn btn_main">CONTACTEAZĂ-NE <i
                                        class="icofont-arrow-right"></i></a>
                                <p><a href="tel:+4 0722 690 504"><i class="icofont-phone-circle"></i> +4
                                        0722 690
                                        504</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <?php include 'config/footer.php' ?>

    </div>

    <div class="modal-basic modal fade show" id="modal-event" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content modal-bg-white ">
                <div class="modal-header">
                    <h6 class="modal-title" id="event-title"></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="admin/img/svg/x.svg" alt="x" class="svg">
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/main.js"></script>
    <script src="js/events.js"></script>

</body>

</html>