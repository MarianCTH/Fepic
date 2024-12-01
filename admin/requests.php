<?php
require_once '../config/config.php';
require_once 'php/config/config-admin.php';

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

$current_page = "Requests";

$query = "SELECT COUNT(*) AS total_cereri, 
                 SUM(Status = 'Nou') AS cereri_noi,
                 SUM(Status = 'Deschis') AS cereri_active,
                 SUM(Status = 'Închis') AS cereri_inchise
          FROM cereri_contact";

$result = $db->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCereri = $row['total_cereri'];
    $cereriNoi = $row['cereri_noi'];
    $cereriActive = $row['cereri_active'];
    $cereriInchise = $row['cereri_inchise'];
} else {
    $totalCereri = 0;
    $cereriNoi = 0;
    $cereriActive = 0;
    $cereriInchise = 0;
}
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


</head>

<body class="layout-light side-menu">
    <div class="mobile-author-actions"></div>
    <?php require_once $config_file . 'header.php'; ?>
    <main class="main-content">
        <?php require_once $config_file . 'sidebar.php'; ?>
        <div class="contents">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-main">
                            <h4 class="text-capitalize breadcrumb-title">Cereri de contact</h4>
                            <div class="breadcrumb-action justify-content-center flex-wrap">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index"><i
                                                    class="uil uil-estate"></i>Acasă</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Cereri de contact
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6  col-ssm-12 mb-30">

                        <div class="ap-po-details ap-po-details--ticket radius-xl d-flex justify-content-between">
                            <div class="overview-content w-100">
                                <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                                    <div class="ap-po-details__titlebar">
                                        <h1 id="total-requests">
                                            <?php echo $totalCereri; ?>
                                        </h1>
                                        <p>Total Cereri</p>
                                    </div>
                                    <div class="ap-po-details__icon-area">
                                        <div class="svg-icon order-bg-opacity-primary">
                                            <img class="svg" src="img/svg/ticket.svg" alt="img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xxl-3 col-sm-6  col-ssm-12 mb-30">

                        <div class="ap-po-details ap-po-details--ticket radius-xl d-flex justify-content-between">
                            <div class="overview-content w-100">
                                <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                                    <div class="ap-po-details__titlebar">
                                        <h1 id="new-requests">
                                            <?php echo $cereriNoi; ?>
                                        </h1>
                                        <p>Cereri noi</p>
                                    </div>
                                    <div class="ap-po-details__icon-area">
                                        <div class="svg-icon order-bg-opacity-secondary">
                                            <img class="svg" src="img/svg/ticket-green1.svg" alt="img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xxl-3 col-sm-6  col-ssm-12 mb-30">

                        <div class="ap-po-details ap-po-details--ticket radius-xl d-flex justify-content-between">
                            <div class="overview-content w-100">
                                <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                                    <div class="ap-po-details__titlebar">
                                        <h1 id="active-requests">
                                            <?php echo $cereriActive; ?>
                                        </h1>
                                        <p>Cereri active</p>
                                    </div>
                                    <div class="ap-po-details__icon-area">
                                        <div class="svg-icon order-bg-opacity-warning">
                                            <img class="svg" src="img/svg/clock-ticket1.svg" alt="img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xxl-3 col-sm-6  col-ssm-12 mb-30">

                        <div class="ap-po-details ap-po-details--ticket radius-xl d-flex justify-content-between">
                            <div class="overview-content w-100">
                                <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                                    <div class="ap-po-details__titlebar">
                                        <h1 id="closed-requests">
                                            <?php echo $cereriInchise; ?>
                                        </h1>
                                        <p>Cereri închise</p>
                                    </div>
                                    <div class="ap-po-details__icon-area">
                                        <div class="svg-icon order-bg-opacity-success">
                                            <img class="svg" src="img/svg/check-circle1.svg" alt="img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 mb-30">
                        <div class="card mt-30">
                            <div class="card-body">
                                <div class="userDatatable adv-table-table global-shadow border-light-0 w-100 adv-table">
                                    <div class="table-responsive">
                                        <div id="filter-form-container"></div>
                                        <table class="table mb-0 table-borderless adv-table" data-sorting="false"
                                            data-filter-container="#filter-form-container" data-paging-current="1"
                                            data-paging-position="right" data-paging-size="10">
                                            <thead>
                                                <tr class="userDatatable-header">
                                                    <th>
                                                        <span class="userDatatable-title">Cod Cerere</span>
                                                    </th>
                                                    <th>
                                                        <span class="userDatatable-title">Utilizator</span>
                                                    </th>
                                                    <th>
                                                        <span class="userDatatable-title">Titlu</span>
                                                    </th>
                                                    <th>
                                                        <span class="userDatatable-title">email</span>
                                                    </th>
                                                    <th data-type="html" data-name="position">
                                                        <span class="userDatatable-title">telefon</span>
                                                    </th>
                                                    <th>
                                                        <span class="userDatatable-title">oraș</span>
                                                    </th>
                                                    <th data-type="html" data-name="status">
                                                        <span class="userDatatable-title">status</span>
                                                    </th>
                                                    <th>
                                                        <span class="userDatatable-title float-end">acțiune</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBody">
                                                <?php
                                                $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                                                $db->set_charset("utf8mb4");

                                                if ($db === false) {
                                                    die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
                                                }
                                                $query = "SELECT * FROM cereri_contact ORDER BY ID_cerere DESC";
                                                $result = mysqli_query($db, $query);

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $id = $row['ID_cerere'];
                                                    $name = $row['Nume'];
                                                    $email = $row['Email'];
                                                    $phone = $row['Telefon'];
                                                    $city = $row['Oras'];
                                                    $titlu = $row['Titlu'];
                                                    $message = $row['Mesaj'];
                                                    $status = $row['Status'];

                                                    echo '<tr id="record' . $id . '" class="data-row">';
                                                    echo '<td><div class="userDatatable-content">#' . $id . '</div></td>';
                                                    echo '<td><div class="d-flex"><div class="userDatatable-inline-title"><a href="#" class="text-dark fw-500"><h6>' . $name . '</h6></a></div></div></td>';
                                                    echo '<td><div class="userDatatable-content">' . $titlu . '</div></td>';
                                                    echo '<td><div class="userDatatable-content"><a href="" class="__cf_email__" data-cfemail="deb4b1b6b0f3b5bbb2b2bbac9eb9b3bfb7b2f0bdb1b3">' . $email . '</a></div></td>';
                                                    echo '<td><div class="userDatatable-content">' . $phone . '</div></td>';

                                                    echo '<td><div class="userDatatable-content">' . $city . '</div></td>';
                                                    if ($status == 'Nou')
                                                        echo '<td><div class="userDatatable-content d-inline-block"><span class="bg-opacity-warning color-warning rounded-pill userDatatable-content-status active" id="status' . $id . '">' . $status . '</span></div></td>';
                                                    else if ($status == 'Deschis')
                                                        echo '<td><div class="userDatatable-content d-inline-block"><span class="bg-opacity-success color-success rounded-pill userDatatable-content-status active" id="status' . $id . '">' . $status . '</span></div></td>';
                                                    else
                                                        echo '<td><div class="userDatatable-content d-inline-block"><span class="bg-opacity-danger color-danger rounded-pill userDatatable-content-status active" id="status' . $id . '">' . $status . '</span></div></td>';

                                                    echo '<td><ul class="orderDatatable_actions mb-0 d-flex flex-wrap">';

                                                    if ($status == 'Nou')
                                                        echo '<li id = "status-button-' . $id . '"><a href="#" class="edit" onclick="markAsSolved(' . $id . ')"><i class="uil uil-check-circle"></i></a></li>';
                                                    else if ($status == 'Deschis')
                                                        echo '<li id = "status-button-' . $id . '"><a href="#" class="edit" onclick="markAsSolved(' . $id . ')"><i class="uil uil-check-circle"></i></a></li>';
                                                    else
                                                        echo '<li id = "status-button-' . $id . '"><a href="#" class="edit" onclick="markAsOpen(' . $id . ')"><i class="uil uil-sync"></i></a></li>';
                                                    echo '<li><a href="read_request.php?requestId=' . $id . '" class="view"><i class="uil uil-eye"></i></a></li>';
                                                    echo '<li><a href="#" class="remove" onclick="confirmDelete(' . $id . ')"><i class="uil uil-trash-alt"></i></a></li>';
                                                    echo '</ul></td>';
                                                    echo '</tr>';
                                                }

                                                mysqli_close($db);
                                                ?>
                                            </tbody>
                                        </table>

                                        <!-- Modal delete -->
                                        <div class="modal fade" id="modal-basic" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-md" role="document">
                                                <div class="modal-content modal-bg-white">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Confirmare</h6>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <img src="img/svg/x.svg" alt="x" class="svg">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm confirm-remove"></button>
                                                        <button type="button"
                                                            class="btn btn-secondary btn-sm cancel-remove"
                                                            data-bs-dismiss="modal"></button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgYKHZB_QKKLWfIRaYPCadza3nhTAbv7c"></script>
    <script src="js/plugins.min.js"></script>
    <script src="js/script.min.js"></script>
    <script>
        function confirmDelete(userId) {
            $('#modal-basic').find('.modal-body p').text('Sigur doriți să ștergeți cererea de contact cu numărul ' + userId + '?');
            $('#modal-basic').find('.modal-footer .confirm-remove').text('Da, șterge');
            $('#modal-basic').find('.modal-footer .cancel-remove').text('Anulează');

            $('#modal-basic').modal('show');

            $('.confirm-remove').off('click').on('click', function () {
                $.ajax({
                    type: 'POST',
                    url: 'php/requests/contact_requests/delete_request.php',
                    data: {
                        userId: userId
                    },
                    success: function (response) {
                        $('#modal-basic').modal('hide');
                        $('#modal-info-success').modal('show');
                        var elementToRemove = document.getElementById('record' + userId);
                        if (elementToRemove) {
                            elementToRemove.remove();
                        }

                        const tableBody = document.getElementById("tableBody");
                        const rowCount = tableBody.getElementsByTagName("tr").length;

                        if (rowCount == 0) {
                            const noResultsRow = '<tr class="footable-empty"><td colspan="8">Nici un rezultat</td></tr>';
                            tableBody.innerHTML = noResultsRow;
                        }

                        var totalCereriElement = document.getElementById('total-requests');
                        var currentValueTotal = parseInt(totalCereriElement.textContent);
                        totalCereriElement.textContent = (currentValueTotal - 1).toString();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        }
        function markAsSolved(userId) {
            $('#modal-basic').find('.modal-body p').text('Doriți să marcați cererea cu numărul ' + userId + ' ca rezolvată?');
            $('#modal-basic').find('.modal-footer .confirm-remove').text('Da, marchează subiectul ca fiind rezolvat');
            $('#modal-basic').find('.modal-footer .cancel-remove').text('Anulează');


            $('.confirm-remove').off('click').on('click', function () {
                $.ajax({
                    type: 'POST',
                    url: 'php/requests/contact_requests/mark_request_as_solved.php',
                    data: {
                        userId: userId
                    },
                    success: function (response) {
                        $('#modal-basic').modal('hide');
                        $('#status' + userId).removeClass('bg-opacity-success color-success').addClass('bg-opacity-danger color-danger');
                        $('#status' + userId).text('Închis');
                        $('#status-button-' + userId).html('<li id = "status-button-' + userId + '"><a href="#" class="edit" onclick="markAsOpen(' + userId + ')"><i class="uil uil-sync"></i></a></li>');

                        var cereriActiveElement = document.getElementById('active-requests');
                        var currentValueActive = parseInt(cereriActiveElement.textContent);
                        cereriActiveElement.textContent = (currentValueActive - 1).toString();

                        var cereriInchiseElement = document.getElementById('closed-requests');
                        var currentValueInchise = parseInt(cereriInchiseElement.textContent);
                        cereriInchiseElement.textContent = (currentValueInchise + 1).toString();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            $('#modal-basic').modal('show');
        }
        function markAsOpen(userId) {
            $('#modal-basic').find('.modal-body p').text('Doriți să redeschideți cererea de contact cu numărul ' + userId + '?');
            $('#modal-basic').find('.modal-footer .confirm-remove').text('Da, redeschide cererea');
            $('#modal-basic').find('.modal-footer .cancel-remove').text('Anulează');


            $('.confirm-remove').off('click').on('click', function () {
                $.ajax({
                    type: 'POST',
                    url: 'php/requests/contact_requests/mark_request_as_open.php',
                    data: {
                        userId: userId
                    },
                    success: function (response) {
                        $('#modal-basic').modal('hide');
                        $('#status' + userId).removeClass('bg-opacity-danger color-danger').addClass('bg-opacity-success color-success');
                        $('#status' + userId).text('Deschis');
                        $('#status-button-' + userId).html('<li id = "status-button-' + userId + '"><a href="#" class="edit" onclick="markAsSolved(' + userId + ')"><i class="uil uil-check-circle"></i></a></li>');

                        var cereriActiveElement = document.getElementById('active-requests');
                        var currentValueActive = parseInt(cereriActiveElement.textContent);
                        cereriActiveElement.textContent = (currentValueActive + 1).toString();

                        var cereriInchiseElement = document.getElementById('closed-requests');
                        var currentValueInchise = parseInt(cereriInchiseElement.textContent);
                        cereriInchiseElement.textContent = (currentValueInchise - 1).toString();

                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            $('#modal-basic').modal('show');
        }
    </script>


</body>

</html>