<?php
require_once '../config/config.php';
require_once 'php/config/config-admin.php';
require_once 'php/logs/log.php';
$logFile = 'php/logs/activity.log';

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

$current_page = "Listă Administratori";

if (isset($_POST['add_user'])) {
    $fullName = $_POST['fullName'];
    $Prenume = $_POST['Prenume'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $person = trim($_POST["person"]);
    $profilePicture = 'default.png';
    $status = 'Activ';

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $conn->set_charset("utf8mb4");
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $existingUserQuery = "SELECT * FROM utilizatori WHERE Email='$email'";
    $existingUserResult = $conn->query($existingUserQuery);
    if ($existingUserResult->num_rows > 0) {
        echo "Email already exists.";
        $conn->close();
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utilizatori (Nume, Prenume, Email, TipCont, Parola, Rol, Poza, Status)
            VALUES ('$fullName', '$Prenume', '$email', '$person', '$hashedPassword', '$role', '$profilePicture', '$status')";

    if ($conn->query($sql) === true) {
        $userId = $conn->insert_id;

        $dateUtilizatoriSql = "INSERT INTO date_utilizatori (ID_utilizator) VALUES ('$userId')";
        $setariNotifSql = "INSERT INTO setari_notificari (id_user) VALUES ('$userId')";
        if ($conn->query($dateUtilizatoriSql) === true && $conn->query($setariNotifSql) === true) {
            echo "User added to the database.";
        } else {
            echo "Error inserting user ID in 'date_utilizatori' table: " . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

?>
<!DOCTYPE html>
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
                        <div class="breadcrumb-main user-member justify-content-sm-between ">
                            <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                                <div
                                    class="d-flex align-items-center user-member__title justify-content-center me-sm-25">
                                    <h4 class="text-capitalize fw-500 breadcrumb-title">Lista utilizatorilor</h4>
                                </div>
                                <form action="" class="d-flex align-items-center user-member__form my-sm-0 my-2">
                                    <img src="img/svg/search.svg" alt="search" class="svg">
                                    <input id="searchInput" class="form-control me-sm-2 border-0 box-shadow-none"
                                        type="search" placeholder="Caută după nume" aria-label="Search">
                                </form>
                            </div>
                            <div class="action-btn">
                                <a href="#" class="btn px-15 btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#new-member">
                                    <i class="las la-plus fs-16"></i>Adaugă Membru</a>

                                <div class="modal fade new-member" id="new-member" role="dialog" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content radius-xl">
                                            <div class="modal-header">
                                                <h6 class="modal-title fw-500" id="staticBackdropLabel">Adaugă
                                                    Membru</h6>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <img src="img/svg/x.svg" alt="x" class="svg">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="new-member-modal">
                                                    <form method="POST">
                                                        <div class="form-group mb-20">
                                                            <input type="text" class="form-control" name="fullName"
                                                                placeholder="Nume" required>
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <input type="text" class="form-control" name="Prenume"
                                                                placeholder="Prenume" required>
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <input type="text" class="form-control" name="email"
                                                                placeholder="Email" required>
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <input type="password" class="form-control" name="password"
                                                                placeholder="Parolă" required>
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <div class="category-member">
                                                                <select
                                                                    class="js-example-basic-single js-states form-control"
                                                                    name="role" id="category-member">
                                                                    <option value="Utilizator">Utilizator</option>
                                                                    <option value="Administrator">Administrator</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <div class="container px-4">
                                                                <div class="row gx-5">
                                                                    <div class="col">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="person" id="flexRadioDefault1"
                                                                            value="Fizică" checked>
                                                                        <label class="form-check-label"
                                                                            for="flexRadioDefault1">
                                                                            Persoană fizică
                                                                        </label>
                                                                    </div>
                                                                    <div class="col">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="person" id="flexRadioDefault2"
                                                                            value="Juridică">
                                                                        <label class="form-check-label"
                                                                            for="flexRadioDefault2">
                                                                            Persoană juridică
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span>Utilizatorii înregistrați de către administrator nu
                                                            necesită verificare pe email.</span>

                                                        <div class="button-group d-flex pt-25">
                                                            <button
                                                                class="btn btn-primary btn-default btn-squared text-capitalize"
                                                                name="add_user" type="submit">Înregistrează</button>
                                                            <button type="button"
                                                                class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light"
                                                                data-bs-dismiss="modal">Anulează</button>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="userDatatable global-shadow border-light-0 p-30 bg-white radius-xl w-100 mb-30">
                            <?php
                            $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                            $connection->set_charset("utf8mb4");
                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                            $pageSize = isset($_GET['page-size']) ? intval($_GET['page-size']) : 10;
                            $offset = ($page - 1) * $pageSize;

                            $sessionid = $_SESSION['id'];
                            $query = "SELECT u.*, d.Adresă, d.Companie
                                      FROM utilizatori u 
                                      INNER JOIN date_utilizatori d ON u.ID = d.ID_utilizator
                                      WHERE u.Rol = 'Administrator'
                                      LIMIT $offset, $pageSize";


                            $result = mysqli_query($connection, $query);

                            if ($result) {
                                echo '
<div class="table-responsive">
    <table class="table mb-0 table-borderless">
        <thead>
            <tr class="userDatatable-header">
                <th>
                    <div class="d-flex align-items-center">
                        <div class="custom-checkbox  check-all">
                            <input class="checkbox" type="checkbox" id="check-44">
                            <label for="check-44">
                                <span class="checkbox-text userDatatable-title">utilizator</span>
                            </label>
                        </div>
                    </div>
                </th>
                <th>
                    <span class="userDatatable-title">email</span>
                </th>
                <th>
                <span class="userDatatable-title">persoană</span>
            </th>
                <th>
                    <span class="userDatatable-title">adresă</span>
                </th>
                <th>
                    <span class="userDatatable-title">data inregistrarii</span>
                </th>
                <th>
                    <span class="userDatatable-title">status</span>
                </th>
                <th>
                    <span class="userDatatable-title float-end">actiune</span>
                </th>
            </tr>
        </thead>
        <tbody id="searchResultsTable">';

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $statusClass = '';
                                    $statusText = $row['Status'];

                                    if ($statusText === 'Dezactivat') {
                                        $statusClass = 'bg-opacity-warning color-warning';
                                    } elseif ($statusText === 'Blocat') {
                                        $statusClass = 'bg-opacity-danger color-danger';
                                    } elseif ($statusText === 'Neverificat') {
                                        $statusClass = 'bg-opacity-warning color-warning';
                                    } elseif ($statusText === 'Activ') {
                                        $statusClass = 'bg-opacity-success color-success';
                                    }

                                    echo '<tr class="searchable-row" id = "row-' . $row['ID'] . '">
        <td>
            <div class="d-flex">
                <div class="userDatatable__imgWrapper d-flex align-items-center">
                    <div class="checkbox-group-wrapper">
                        <div class="checkbox-group d-flex">
                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                <input class="checkbox" type="checkbox" id="check-grp-content12">
                                <label for="check-grp-content12"></label>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="profile-image rounded-circle d-block m-0 wh-38" style="background-image:url(\'../images/profile/' . $row['Poza'] . '\');background-size: cover;"></a>
                </div>
                <div class="userDatatable-inline-title">
                    <a href="#" class="text-dark fw-500">
                        <h6>' . $row['Nume'] . ' ' . $row['Prenume'] . '</h6>
                    </a>
                    <p class="d-block mb-0">' . $row['Companie'] . '</p>
                </div>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                <a href="mailto:' . $row['Email'] . '">' . $row['Email'] . '</a>
            </div>
        </td>
        <td>
        <div class="userDatatable-content">' . $row['TipCont'] . '</div>
    </td>
        <td>
            <div class="userDatatable-content">' . $row['Adresă'] . '</div>
        </td>
        <td>
            <div class="userDatatable-content">' . $row['DataInregistrarii'] . '</div>
        </td>
        <td>
            <div class="userDatatable-content d-inline-block">
                <span id="status-' . $row['ID'] . '" class="' . $statusClass . ' rounded-pill userDatatable-content-status active">' . $statusText . '</span>
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                <li>
                    <a href="#" onclick="confirmBlock(' . $row['ID'] . ')" class="view">
                        <i class="uil uil-ban"></i>
                    </a>
                </li>
                <li>
                    <a href="edit-user.php?id=' . $row['ID'] . '" class="edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="confirmDelete(' . $row['ID'] . ')" class="remove">
                        <i class="uil uil-trash-alt"></i>
                    </a>
                </li>
            </ul>
        </td>
    </tr>';
                                }

                                echo '</tbody>
    </table>
</div>';
                            }
                            $query = "SELECT COUNT(*) AS total_records FROM utilizatori WHERE Rol = 'Administrator'";
                            $result = mysqli_query($connection, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $totalRecords = $row['total_records'];

                                mysqli_free_result($result);

                                $pageSize = isset($_GET['page-size']) ? $_GET['page-size'] : 10;
                                $totalPages = ceil($totalRecords / $pageSize);

                            } else {
                                echo "Error: " . mysqli_error($connection);
                            }

                            mysqli_close($connection);
                            ?>



                            <div class="d-flex justify-content-end pt-30">
                                <nav class="dm-page">
                                    <ul class="dm-pagination d-flex">
                                        <li class="dm-pagination__item">

                                            <?php
                                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                                            $startPage = max(1, $currentPage - 2);
                                            $endPage = min($startPage + 4, $totalPages);

                                            if ($totalPages > 1) {
                                                if ($currentPage > 1) {
                                                    echo '<a href="?page=1&page-size=' . $pageSize . '" class="dm-pagination__link"><span class="la la-angle-double-left"></span></a>';
                                                    echo '<a href="?page=' . ($currentPage - 1) . '&page-size=' . $pageSize . '" class="dm-pagination__link"><span class="la la-angle-left"></span></a>';
                                                } else {
                                                    echo '<span class="dm-pagination__link disabled"><span class="la la-angle-double-left"></span></span>';
                                                    echo '<span class="dm-pagination__link disabled"><span class="la la-angle-left"></span></span>';
                                                }

                                                for ($i = $startPage; $i <= $endPage; $i++) {
                                                    $activeClass = ($currentPage == $i) ? 'active' : '';
                                                    echo '<a href="?page=' . $i . '&page-size=' . $pageSize . '" class="dm-pagination__link ' . $activeClass . '"><span class="page-number">' . $i . '</span></a>';
                                                }

                                                if ($currentPage < $totalPages) {
                                                    echo '<a href="?page=' . ($currentPage + 1) . '&page-size=' . $pageSize . '" class="dm-pagination__link"><span class="la la-angle-right"></span></a>';
                                                    echo '<a href="?page=' . $totalPages . '&page-size=' . $pageSize . '" class="dm-pagination__link"><span class="la la-angle-double-right"></span></a>';
                                                } else {
                                                    echo '<span class="dm-pagination__link disabled"><span class="la la-angle-right"></span></span>';
                                                    echo '<span class="dm-pagination__link disabled"><span class="la la-angle-double-right"></span></span>';
                                                }
                                            } else {
                                                echo '<span class="dm-pagination__link disabled"><span class="la la-angle-double-left"></span></span>';
                                                echo '<span class="dm-pagination__link disabled"><span class="la la-angle-left"></span></span>';
                                                echo '<span class="dm-pagination__link disabled"><span class="la la-angle-right"></span></span>';
                                                echo '<span class="dm-pagination__link disabled"><span class="la la-angle-double-right"></span></span>';
                                            }
                                            ?>



                                            <a href="#" class="dm-pagination__option"></a>
                                        </li>
                                        <li class="dm-pagination__item">
                                            <div class="paging-option">
                                                <select name="page-size" class="page-selection"
                                                    onchange="changePageSize(this.value)">
                                                    <option value="10" <?php if ($pageSize == 10)
                                                        echo 'selected'; ?>>
                                                        10/pagină</option>
                                                    <option value="20" <?php if ($pageSize == 20)
                                                        echo 'selected'; ?>>
                                                        20/pagină</option>
                                                    <option value="40" <?php if ($pageSize == 40)
                                                        echo 'selected'; ?>>
                                                        40/pagină</option>
                                                    <option value="60" <?php if ($pageSize == 60)
                                                        echo 'selected'; ?>>
                                                        60/pagină</option>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
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

    <div class="modal-basic modal fade show" id="confirmare" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content modal-bg-white ">
                <div class="modal-header">
                    <h6 class="modal-title">Confirmare</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <img src="img/svg/x.svg" alt="x" class="svg">
                    </button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm">Sigur</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Anulează</button>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay-dark-sidebar"></div>
    <div class="customizer-overlay"></div>
    <?php require_once $config_file . 'customizer-wrapper.php'; ?>
    <script src="js/plugins.min.js"></script>
    <script src="js/script.min.js"></script>
    <script src="js/search.js"></script>
    <script>
        function confirmDelete(userId) {
            const modal = document.getElementById('confirmare');

            const modalBody = modal.querySelector('.modal-body');
            modalBody.innerHTML = '<p>Sunteți sigur că doriți să continuați cu ștergerea acestui utilizator ? Vă rugăm să fiți conștient că această acțiune este ireversibilă și nu poate fi anulată.</p > ';

            const modalFooter = modal.querySelector('.modal-footer');
            modalFooter.innerHTML = `
                <button type="button" class="btn btn-primary btn-sm" data-user-id="${userId}">Sigur</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Anulează</button>
            `;

            $(modal).modal('show');

            modalFooter.querySelector('.btn-primary').addEventListener('click', function () {
                const user_id = this.getAttribute('data-user-id');
                const action = 'delete';
                const url = `php/user/delete_user.php?action=${action}&user_id=${user_id}`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        $(modal).modal('hide');
                        modalBody.innerHTML = '';
                        modalFooter.innerHTML = `
                            <button type="button" class="btn btn-primary btn-sm">Sigur</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Anulează</button>`;


                        if (data.status === 'success') {
                            const row = document.getElementById("row-" + userId);
                            if (row) {
                                row.remove();
                            } else {
                                console.log("Row not found");
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                    });
            });
        }

        function confirmBlock(userId) {
            const modal = document.getElementById('confirmare');

            const modalBody = modal.querySelector('.modal-body');
            modalBody.innerHTML = '<p>Sigur doriți să blocați acest utilizator?</p>';

            const modalFooter = modal.querySelector('.modal-footer');
            modalFooter.innerHTML = `
                <button type="button" class="btn btn-primary btn-sm" data-user-id="${userId}">Sigur</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Anulează</button>
            `;

            $(modal).modal('show');

            modalFooter.querySelector('.btn-primary').addEventListener('click', function () {
                const user_id = this.getAttribute('data-user-id');
                const action = 'block';
                const url = `php/user/block_user.php?action=${action}&user_id=${user_id}`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        $(modal).modal('hide');
                        modalBody.innerHTML = '';
                        modalFooter.innerHTML = `
                            <button type="button" class="btn btn-primary btn-sm">Sigur</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Anulează</button>`;

                        if (data.status === 'success') {
                            const statusElement = document.getElementById('status-' + userId);
                            if (statusElement) {
                                statusElement.textContent = "Blocat";
                                statusElement.className = 'bg-opacity-danger color-danger rounded-pill userDatatable-content-status active';
                            } else {
                                console.log("Element not found");
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                    });
            });
        }

        function changePageSize(pageSize) {
            const url = new URL(window.location.href);
            url.searchParams.set('page-size', pageSize);
            window.location.href = url.toString();
        }
    </script>
</body>

</html>