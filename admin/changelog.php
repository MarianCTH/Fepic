<?php
require_once '../config/config.php';
require_once 'php/config/config-admin.php';

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

$current_page = "Changelog";
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
                            <h4 class="text-capitalize breadcrumb-title">Actualizări</h4>
                            <div class="breadcrumb-action justify-content-center flex-wrap">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#"><i class="uil uil-estate"></i>Acasă</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            <?php echo $current_page; ?>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 changelog-19 d-block">
                        <div class="changelog mb-30">
                            <div class="card">
                                <div class="card-body p-30">
                                    <div class="changelog__according">
                                        <div class="changelog__accordingWrapper">
                                            <div id="accordion">
                                                <?php
                                                $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                                                $conn->set_charset("utf8mb4");
                                                if ($conn->connect_error) {
                                                    die("Connection failed: " . $conn->connect_error);
                                                }

                                                $sql = "SELECT * FROM changelog ORDER BY ID_update DESC LIMIT 10";
                                                $result = $conn->query($sql);
                                                ?>

                                                <?php while ($row = $result->fetch_assoc()): ?>
                                                    <div class="card">
                                                        <div class="card-header w-100 px-sm-30 px-15"
                                                            id="heading<?php echo $row['ID_update']; ?>">
                                                            <div role="button"
                                                                class="w-100 changelog__accordingCollapsed collapsed"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse<?php echo $row['ID_update']; ?>"
                                                                aria-expanded="true"
                                                                aria-controls="collapse<?php echo $row['ID_update']; ?>">
                                                                <div
                                                                    class="changelog__accordingTitle d-flex justify-content-between w-100">
                                                                    <div class="v-num">
                                                                        <?php echo $row['Version']; ?><span
                                                                            class="v-arrow">-</span>
                                                                        <span class="rl-date">
                                                                            <?php echo date('M d, Y', strtotime($row['Date'])); ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="changelog__accordingArrow">
                                                                        <span data-feather="chevron-right"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="collapse<?php echo $row['ID_update']; ?>" class="collapse"
                                                            aria-labelledby="heading<?php echo $row['ID_update']; ?>"
                                                            data-parent="#accordion">
                                                            <div class="card-body">
                                                                <div class="version-list">
                                                                    <?php $newUpdates = explode(',', $row['New']); ?>
                                                                    <?php if (strlen($row['New']) > 0): ?>
                                                                        <div class="version-list__single">
                                                                            <div class="version-list__top">
                                                                                <span
                                                                                    class="badge badge-round badge-success badge-lg">Nou</span>
                                                                            </div>
                                                                            <ul class="version-success">
                                                                                <?php foreach ($newUpdates as $update): ?>
                                                                                    <?php if (strlen($update) > 0): ?>
                                                                                        <li>
                                                                                            <?php echo $update; ?>
                                                                                        </li>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            </ul>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                    <?php $fixedUpdates = explode(',', $row['Fixed']); ?>
                                                                    <?php if (strlen($row['Fixed']) > 0): ?>
                                                                        <div class="version-list__single">
                                                                            <div class="version-list__top">
                                                                                <span
                                                                                    class="badge badge-round badge-info badge-lg">Reparat</span>
                                                                            </div>
                                                                            <ul class="version-info">
                                                                                <?php foreach ($fixedUpdates as $update): ?>
                                                                                    <?php if (strlen($update) > 0): ?>
                                                                                        <li>
                                                                                            <?php echo $update; ?>
                                                                                        </li>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            </ul>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                    <?php $updatedUpdates = explode(',', $row['Updated']); ?>
                                                                    <?php if (strlen($row['Updated']) > 0): ?>
                                                                        <div class="version-list__single">
                                                                            <div class="version-list__top">
                                                                                <span
                                                                                    class="badge badge-round badge-primary badge-lg">Actualizat</span>
                                                                            </div>
                                                                            <ul class="version-primary">
                                                                                <?php foreach ($updatedUpdates as $update): ?>
                                                                                    <?php if (strlen($update) > 0): ?>
                                                                                        <li>
                                                                                            <?php echo $update; ?>
                                                                                        </li>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            </ul>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endwhile; ?>

                                                <?php
                                                $conn->close();
                                                ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 changelog-5 d-block  mb-30">
                        <div class="card changeLog-history h-100">
                            <div class="card-header py-20 px-20">
                                <div class="changelog-history__title text-uppercase">
                                    ACTUALIZĂRI
                                </div>
                                <div class="changelog-history__titleExtra">
                                </div>
                            </div>
                            <?php
                            $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                            $db->set_charset("utf8mb4");
                            if ($db->connect_error) {
                                die("Connection failed: " . $db->connect_error);
                            }
                            $query = "SELECT Version, Date FROM changelog ORDER BY Date DESC LIMIT 10";
                            $result = mysqli_query($db, $query);

                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    echo '<div class="card-body p-25">';
                                    echo '<h4 class="history-title">ISTORIC VERSIUNI</h4>';
                                    echo '<ul class="v-history-list">';

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $version = $row['Version'];
                                        $date = date('F d, Y', strtotime($row['Date']));

                                        echo '<li>';
                                        echo '<span class="version-name">' . $version . '</span>';
                                        echo '<span class="version-date">' . $date . '</span>';
                                        echo '</li>';
                                    }

                                    echo '</ul>';
                                    echo '</div>';
                                } else {
                                    echo 'No version history found.';
                                }

                                mysqli_free_result($result);
                            } else {
                                echo 'Error in executing the query: ' . mysqli_error($db);
                            }

                            mysqli_close($db);
                            ?>


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

</body>

</html>