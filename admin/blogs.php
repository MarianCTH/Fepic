<?php
require_once '../config/config.php';
require_once 'php/config/config-admin.php';

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}
$current_page = "Postări";
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
                                <h4 class="text-capitalize breadcrumb-title">Postări</h4>
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
                        <div class="col-xxl-3 col-sm-6  col-ssm-12 mb-30">

                            <div class="ap-po-details ap-po-details--ticket radius-xl d-flex justify-content-between">
                                <div class="overview-content w-100">
                                    <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                                        <div class="ap-po-details__titlebar">
                                            <h1 id="total-subscribers">
                                            </h1>
                                            <p>Abonați</p>
                                        </div>
                                        <div class="ap-po-details__icon-area">
                                            <div class="svg-icon order-bg-opacity-primary">
                                                <img class="svg" src="img/svg/user.svg" alt="img">
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
                                            <h1 id="total-views">
                                            </h1>
                                            <p>Vizualizări</p>
                                        </div>
                                        <div class="ap-po-details__icon-area">
                                            <div class="svg-icon order-bg-opacity-secondary">
                                                <img class="svg" src="img/svg/eye.svg" alt="img">
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
                                            <h1 id="total-likes">
                                            </h1>
                                            <p>Like-uri</p>
                                        </div>
                                        <div class="ap-po-details__icon-area">
                                            <div class="svg-icon order-bg-opacity-warning">
                                                <i class="uil uil-thumbs-up"></i>
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
                                            <h1 id="total-comments">
                                            </h1>
                                            <p>Comentarii</p>
                                        </div>
                                        <div class="ap-po-details__icon-area">
                                            <div class="svg-icon order-bg-opacity-success">
                                                <i class="uil uil-comment-alt-dots"></i>
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

                        $itemsPerPage = isset($_GET['items']) ? $_GET['items'] : 6;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                        $offset = ($page - 1) * $itemsPerPage;

                        $query = "SELECT * FROM blog ORDER BY Nr_articol DESC LIMIT $offset, $itemsPerPage";
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

                            $likesCount = count(explode(',', $row['LikedBy']));

                            echo '
                            <div class="col-xl-4 col-md-6 mb-25">
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
                                                <a href="../' . $row["permalink"] . '" class="entry-title"
                                                    rel="bookmark">' . $row['Subiect'] . '</a>
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
                                                            <span class="blog-card__meta-reaction-like">' . $likesCount - 1 . '</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="blog-card__meta-doc-wrapper">
                                                            <img src="img/svg/comment.svg" alt="file-text" class="svg">
                                                            <span class="blog-card__meta-doc">' . $commentsData['CommentCount'] . '</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="dropdown  dropdown-hover">
                                                            <a class="btn-link" href>
                                                                <img src="img/svg/more-horizontal.svg" alt="chevron-down" class="svg">
                                                            </a>
                                                            <div class="dropdown-default">
                                                            <a class="dropdown-item" href="../blog.php?id=' . $row['Nr_articol'] . '" id="blog-edit"><i class="uil uil-eye"></i> Vizualizează</a>
                                                            <a class="dropdown-item" href="blog-edit.php?id=' . $row['Nr_articol'] . '" id="blog-edit"><i class="uil uil-edit"></i> Editează</a>
                                                            <a class="dropdown-item" href="#" onclick="deleteRecord(' . $row['Nr_articol'] . ')" id="blog-delete"><i class="uil uil-times-circle"></i> Șterge</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }

                        $totalItemsQuery = "SELECT COUNT(*) AS TotalItems FROM blog";
                        $totalItemsResult = mysqli_query($connection, $totalItemsQuery);
                        $totalItemsData = mysqli_fetch_assoc($totalItemsResult);
                        $totalItems = $totalItemsData['TotalItems'];

                        $totalPages = ceil($totalItems / $itemsPerPage);

                        echo '
<div class="col-12">
    <div class="d-flex justify-content-end mt-1 mb-50">
        <nav class="dm-page">
            <ul class="dm-pagination d-flex">';

                        if ($totalPages > 1) {
                            if ($page > 1) {
                                echo '<li class="dm-pagination__item">
            <a href="?page=' . ($page - 1) . '" class="dm-pagination__link pagination-control"><span class="la la-angle-left"></span></a>
        </li>';
                            }

                            for ($i = 1; $i <= $totalPages; $i++) {
                                if ($i == $page) {
                                    echo '<li class="dm-pagination__item"><a href="#" class="dm-pagination__link active"><span class="page-number">' . $i . '</span></a></li>';
                                } else {
                                    echo '<li class="dm-pagination__item"><a href="?page=' . $i . '" class="dm-pagination__link"><span class="page-number">' . $i . '</span></a></li>';
                                }
                            }

                            if ($page < $totalPages) {
                                echo '<li class="dm-pagination__item">
            <a href="?page=' . ($page + 1) . '" class="dm-pagination__link pagination-control"><span class="la la-angle-right"></span></a>
        </li>';
                            }

                            echo '
        <li class="dm-pagination__item">
            <div class="paging-option">
                <select name="page-number" class="page-selection" id="items-per-page">
                    <option value="6" ' . ($itemsPerPage == 6 ? 'selected' : '') . '>6/pagină</option>
                    <option value="12" ' . ($itemsPerPage == 12 ? 'selected' : '') . '>12/pagină</option>
                    <option value="18" ' . ($itemsPerPage == 18 ? 'selected' : '') . '>18/pagină</option>
                </select>
            </div>
        </li>';
                        }

                        echo '
            </ul>
        </nav>
    </div>
</div>';

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
    <script>
        if (document.getElementById('items-per-page')) {
            document.getElementById('items-per-page').addEventListener('change', function () {
                var selectedValue = this.value;
                var currentUrl = window.location.href;
                var newUrl = currentUrl.replace(/(&|\?)items=\d+/, '');
                newUrl += (newUrl.indexOf('?') === -1 ? '?' : '&') + 'items=' + selectedValue;
                window.location.href = newUrl;
            });
        }
    </script>
    <script>
        function deleteRecord(nrArticol) {
            if (confirm("Sigur dorești să ștergi această postare?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "php/blog/delete_blog.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = xhr.responseText;
                        if (response === "success") {
                            location.reload();
                        } else {
                            alert("Failed to delete the record.");
                        }
                    }
                };
                xhr.send("nr_articol=" + encodeURIComponent(nrArticol));
            }
        }
        const blogSubscribers = document.getElementById("total-subscribers");
    const blogViews = document.getElementById("total-views");
    const blogLikes = document.getElementById("total-likes");
    const blogComments = document.getElementById("total-comments");

    function generateBlogStats() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "php/blog/get_blog_stats.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    blogSubscribers.textContent = response.subscribers;
                    blogViews.textContent = response.views;
                    blogLikes.textContent = response.likes;
                    blogComments.textContent = response.comments;
                } else {
                    alert("Failed to fetch blog stats.");
                }
            }
        };
        xhr.send();
    }

    if (blogSubscribers && blogViews && blogLikes && blogComments) {
        generateBlogStats();
    }

    </script>
</body>

</html>