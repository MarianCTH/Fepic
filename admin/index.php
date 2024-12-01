<?php
require_once '../config/config.php';
require_once 'php/config/config-admin.php';


session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}
$current_page = "Panou Principal";
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
            <div class="demo5 mt-30 mb-25">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xxl-12 mb-25">
                            <div class="card banner-feature--18 d-flex">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="card-body px-25">
                                                <h1 class="banner-feature__heading color-white">Bine ai venit
                                                    <?php echo $_SESSION['username']; ?>
                                                </h1>
                                                <p class="banner-feature__para color-white">
                                                    Pentru a fi la curent cu cele mai recente actualizări, vă rugăm să
                                                    accesați opțiunea de mai jos.
                                                </p>
                                                <div class="d-flex justify-content-sm-start justify-content-center">
                                                    <a href="changelog.php"
                                                        class="banner-feature__btn btn btn-primary color-white btn-md px-20 radius-xs fs-15"
                                                        type="button">Ultimele Actualizări
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div
                                                class="banner-feature__shape px-md-25 px-25 py-sm-0 pt-15 pb-30 d-flex justify-content-sm-end justify-content-center">
                                                <img src="img/demo5-banner.png" alt="img" class="svg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 mb-25">
                            <div class="card revenueChartTwo border-0">
                                <div class="card-header border-0">
                                    <h6>Utilizatori</h6>
                                    <div class="card-extra">
                                        <ul class="card-tab-links nav-tabs nav" role="tablist">
                                            <li>
                                                <a class="active" href="#tl_revenue-today" data-bs-toggle="tab"
                                                    id="tl_revenue-today-tab" role="tab"
                                                    aria-selected="false">Astăzi</a>
                                            </li>
                                            <li>
                                                <a href="#tl_revenue-week" data-bs-toggle="tab" id="tl_revenue-week-tab"
                                                    role="tab" aria-selected="false">Săptămână</a>
                                            </li>
                                            <li>
                                                <a href="#tl_revenue-month" data-bs-toggle="tab"
                                                    id="tl_revenue-month-tab" role="tab" aria-selected="false">Lună</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-body pt-0 pb-40">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="tl_revenue-today" role="tabpanel"
                                            aria-labelledby="tl_revenue-today-tab">
                                            <div class="cashflow-display cashflow-display2 d-flex">
                                            </div>

                                            <div class="wp-chart">
                                                <div class="parentContainer">
                                                    <div>
                                                        <canvas id="usersToday"></canvas>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="tl_revenue-week" role="tabpanel"
                                            aria-labelledby="tl_revenue-week-tab">
                                            <div class="cashflow-display cashflow-display2 d-flex">
                                            </div>

                                            <div class="wp-chart">
                                                <div class="parentContainer">
                                                    <div>
                                                        <canvas id="usersWeek"></canvas>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="tl_revenue-month" role="tabpanel"
                                            aria-labelledby="tl_revenue-month-tab">
                                            <div class="cashflow-display cashflow-display2 d-flex">
                                            </div>

                                            <div class="wp-chart">
                                                <div class="parentContainer">
                                                    <div>
                                                        <canvas id="usersMonth"></canvas>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xxl-6 mb-25">
                            <div class="card border-0 px-25 pb-15 h-100">
                                <div class="card-header px-0 border-0">
                                    <h6>Ultimii utilizatori înregistrați</h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="t_selling-today22" role="tabpanel"
                                            aria-labelledby="t_selling-today22-tab">
                                            <div
                                                class="selling-table-wrap selling-table-wrap--source selling-table-wrap--member">
                                                <div class="table-responsive">
                                                    <table class="table table--default table-borderless">
                                                        <tbody>
                                                            <?php
                                                            $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                                                            $connection->set_charset("utf8mb4");
                                                            if ($connection->connect_error) {
                                                                die("Connection failed: " . $connection->connect_error);
                                                            }

                                                            $query = "SELECT u.*, d.* FROM utilizatori u
          LEFT JOIN date_utilizatori d ON u.ID = d.ID_utilizator
          ORDER BY u.DataInregistrarii DESC LIMIT 5";
                                                            $result = mysqli_query($connection, $query);

                                                            if ($result && mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    setlocale(LC_TIME, 'ro_RO.utf8');

                                                                    $romanianMonths = array(
                                                                        'Ianuarie',
                                                                        'Februarie',
                                                                        'Martie',
                                                                        'Aprilie',
                                                                        'Mai',
                                                                        'Iunie',
                                                                        'Iulie',
                                                                        'August',
                                                                        'Septembrie',
                                                                        'Octombrie',
                                                                        'Noiembrie',
                                                                        'Decembrie'
                                                                    );

                                                                    $dateTime = new DateTime($row['DataInregistrarii']);
                                                                    $dayOfMonth = $dateTime->format('j');
                                                                    $monthIndex = $dateTime->format('n') - 1;
                                                                    $hourAndMinute = $dateTime->format('H:i');

                                                                    $hourOfRegistration = $dayOfMonth . ' ' . $romanianMonths[$monthIndex] . ' (' . $hourAndMinute . ')';
                                                                    $profileCompletion = calculateProfileCompletion($row);

                                                                    echo '<tbody>';
                                                                    echo '<tr>';
                                                                    echo '<td>';
                                                                    echo '<div class="selling-product-img d-flex align-items-center">';
                                                                    echo '<div class="selling-product-img-wrapper order-bg-opacity-primary">';
                                                                    echo '<img class="img-fluid" src="img/author/robert-1.png" alt="img">';
                                                                    echo '</div>';
                                                                    echo '<span><a href="edit-user.php?id=' . $row['ID'] . '">' . $row['Nume'] . ' ' . $row['Prenume'] . '</span></a>';
                                                                    echo '</div>';
                                                                    echo '</td>';
                                                                    echo '<td>' . $hourOfRegistration . '</td>';
                                                                    echo '<td>';
                                                                    echo '<div class="status">';
                                                                    echo '<ul>';
                                                                    echo '<li>' . $row['Status'] . '</li>';
                                                                    echo '</ul>';
                                                                    echo '</div>';
                                                                    echo '</td>';
                                                                    echo '<td>';
                                                                    echo '<div class="d-flex align-center justify-content-end">';
                                                                    echo '<div class="progress-wrap mb-0">';
                                                                    echo '<div class="progress">';
                                                                    echo '<div class="progress-bar ';
                                                                    if ($profileCompletion <= 25) {
                                                                        echo 'bg-warning';
                                                                    } elseif ($profileCompletion > 25 && $profileCompletion < 50) {
                                                                        echo 'bg-info';
                                                                    } elseif ($profileCompletion >= 50 && $profileCompletion < 75) {
                                                                        echo 'bg-secondary';
                                                                    } else {
                                                                        echo 'bg-success';
                                                                    }
                                                                    echo '" role="progressbar" style="width: ' . $profileCompletion . '%;" aria-valuenow="' . $profileCompletion . '" aria-valuemin="0" aria-valuemax="100"></div>';
                                                                    echo '</div>';
                                                                    echo '</div>';
                                                                    echo '<div class="ratio-percentage ms-10">' . $profileCompletion . '%</div>';
                                                                    echo '</div>';
                                                                    echo '</td>';
                                                                    echo '</tr>';
                                                                    echo '</tbody>';
                                                                }
                                                            }

                                                            mysqli_close($connection);

                                                            function calculateProfileCompletion($row)
                                                            {
                                                                $fieldsToCheck = array(
                                                                    'Adresă',
                                                                    'Data_nasterii',
                                                                    'Companie',
                                                                    'Rol Companie',
                                                                    'Telefon',
                                                                    'CUI',
                                                                );

                                                                $totalFields = count($fieldsToCheck);
                                                                $completedFields = 0;

                                                                foreach ($fieldsToCheck as $field) {
                                                                    if (!empty($row[$field])) {
                                                                        $completedFields++;
                                                                    }
                                                                }

                                                                $profileCompletion = ($completedFields / $totalFields) * 100;
                                                                return round($profileCompletion);
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                        $connection->set_charset("utf8mb4");
                        if ($connection->connect_error) {
                            die("Connection failed: " . $connection->connect_error);
                        }
                        $query = "SELECT * FROM blog ORDER BY Nr_articol DESC LIMIT 3";
                        $result = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $text = $row['Text'];
                            $text = strlen($text) > 173 ? substr($text, 0, 173) . "..." : $text;

                            $authorQuery = "SELECT Poza, CONCAT(Nume, ' ', Prenume) AS Autor FROM utilizatori WHERE ID = " . $row['ID_autor'];
                            $authorResult = mysqli_query($connection, $authorQuery);
                            $authorData = mysqli_fetch_assoc($authorResult);

                            $commentsQuery = "SELECT COUNT(*) AS CommentCount FROM comentarii_postare WHERE ID_postare = " . $row['Nr_articol'];
                            $commentsResult = mysqli_query($connection, $commentsQuery);
                            $commentsData = mysqli_fetch_assoc($commentsResult);

                            $likesQuery = "SELECT COUNT(*) AS LikeCount FROM blog WHERE Nr_articol = " . $row['Nr_articol'];
                            $likesResult = mysqli_query($connection, $likesQuery);
                            $likesData = mysqli_fetch_assoc($likesResult);
                            $likeCount = $likesData['LikeCount'];

                            echo '
        <div class="col-xxl-4 col-lg-6 mb-25">
            <div class="blog-card">
                <div class="blog-card__thumbnail">
                    <a href="#">
                        <img src="../images/blog/' . $row['Image'] . '" alt>
                    </a>
                </div>
                <div class="blog-card__details">
                    <div class="blog-card__content">
                        <div class="blog-card__title--top">' . $row['Data'] . '</div>
                        <h4 class="blog-card__title">
                            <a href="../' . $row["permalink"] . '" class="entry-title" rel="bookmark">' . $row['Subiect'] . '</a>
                        </h4>
                        <p>' . $text . '</p>
                    </div>
                    <div class="blog-card__meta">
                        <div class="blog-card__meta-profile">
                            <img src="../images/profile/' . $authorData['Poza'] . '" alt>
                            <span>' . $authorData['Autor'] . '</span>
                        </div>
                        <div class="blog-card__meta-count">
                            <ul>
                                <li>
                                    <div class="blog-card__meta-doc-wrapper">
                                        <img src="img/svg/eye.svg" alt="file-text" class="svg">
                                        <span class="blog-card__meta-doc">' . $row['Vizualizari'] . '</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="blog-card__meta-reaction">
                                        <img src="img/svg/heart.svg" alt="heart" class="svg">
                                        <span class="blog-card__meta-reaction-like">' . $likeCount . '</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="blog-card__meta-doc-wrapper">
                                        <img src="img/svg/file-text.svg" alt="file-text" class="svg">
                                        <span class="blog-card__meta-doc">' . $commentsData['CommentCount'] . '</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
                        }

                        mysqli_close($connection);
                        ?>
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
</body>

</html>