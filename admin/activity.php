<?php
require_once '../config/config.php';
require_once 'php/config/config-admin.php';

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}
$current_page = "Activitate";

$logFile = 'php/logs/activity.log';
$logContent = file_get_contents($logFile);
$logLines = explode("\n", $logContent);
$logLines = array_reverse($logLines);
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
                <div class="social-dash-wrap">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-main">
                                <h4 class="text-capitalize breadcrumb-title">Activitate globală</h4>
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
                    <div class="row" style="margin-bottom: 1rem;">
                        <div class="col-md-12">
                            <div class="card">
                                <?php                                
                                $perPage = 40;
                                $totalLogs = count($logLines);
                                $totalPages = ceil($totalLogs / $perPage);
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $offset = ($page - 1) * $perPage;

                                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                                if (!empty($searchTerm)) {
                                    $filteredLogs = array_filter($logLines, function ($line) use ($searchTerm) {
                                        return stripos($line, $searchTerm) !== false;
                                    });
                                    $totalLogs = count($filteredLogs);
                                    $totalPages = ceil($totalLogs / $perPage);
                                    $paginatedLogs = array_slice($filteredLogs, $offset, $perPage);
                                } else {
                                    $paginatedLogs = array_slice($logLines, $offset, $perPage);
                                }
                                ?>

                                <div class="search-result global-shadow rounded-pill bg-white" style="margin: 1rem 1rem 1rem 1rem;">
                                    <form action="" method="get"
                                        class="d-flex align-items-center justify-content-between">
                                        <div
                                            class="border-right d-flex align-items-center w-100 ps-25 pe-sm-25 pe-0 py-1">
                                            <img src="img/svg/search.svg" alt="search" class="svg">
                                            <input class="form-control border-0 box-shadow-none" type="text"
                                                name="search" placeholder="Caută..."
                                                value="<?php echo htmlentities($searchTerm); ?>">
                                        </div>
                                        <button type="submit" class="border-0 bg-transparent px-25">Caută</button>
                                    </form>
                                </div>

                                <div class="card-body">
                                    <ul>
                                        <?php foreach ($paginatedLogs as $line): ?>
                                            <li>
                                                <?php echo highlightSearchTerm($line, $searchTerm); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                                <div class="d-flex justify-content-end pt-30"
                                    style="margin-bottom: 1rem; margin-right: 2rem;">
                                    <nav class="dm-page">
                                        <ul class="dm-pagination d-flex">
                                            <li class="dm-pagination__item">
                                                <?php if ($page > 1): ?>
                                                    <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($searchTerm); ?>"
                                                        class="dm-pagination__link pagination-control">
                                                        <span class="la la-angle-left"></span>
                                                    </a>
                                                <?php endif; ?>
                                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                    <?php if ($page == $i): ?>
                                                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchTerm); ?>"
                                                            class="dm-pagination__link active">
                                                            <span class="page-number">
                                                                <?php echo $i; ?>
                                                            </span>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchTerm); ?>"
                                                            class="dm-pagination__link">
                                                            <span class="page-number">
                                                                <?php echo $i; ?>
                                                            </span>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                                <?php if ($page < $totalPages): ?>
                                                    <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($searchTerm); ?>"
                                                        class="dm-pagination__link pagination-control">
                                                        <span class="la la-angle-right"></span>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="#" class="dm-pagination__option"></a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                            <?php
                            function highlightSearchTerm($line, $searchTerm)
                            {
                                if (!empty($searchTerm)) {
                                    $highlightedTerm = '<a href="#">' . htmlentities($searchTerm) . '</a>';
                                    $line = str_ireplace($searchTerm, $highlightedTerm, $line);
                                }
                                return $line;
                            }
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