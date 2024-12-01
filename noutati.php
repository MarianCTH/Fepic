<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_log', 'error.log');
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Noutăți</title>

  <script defer src="https://europa.eu/webtools/load.js" type="text/javascript"></script>
  <link rel="stylesheet" href="css/icofont.min.css">
  <link rel="stylesheet" href="css/animate.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

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
            <h2>Ultimele anunțuri</h2>
            <ul>
              <li><a href="index">Acasă</a></li>
              <li><span>»</span></li>
              <li><a href="noutati">Noutăți</a></li>
            </ul>
          </div>
        </div>
      </div>

    </div>

    <section class="blog_list_section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="blog_left_side">
              <?php
              $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
              $db->set_charset("utf8mb4");

              if ($db === false) {
                die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
              }
              $limit = 4;
              $page = isset($_GET['page']) ? $_GET['page'] : 1;
              $offset = ($page - 1) * $limit;

              $category = isset($_GET['category']) ? $_GET['category'] : null;
              $categoryCondition = $category ? "AND Categorie = '$category'" : "";

              $tag = isset($_GET['tag']) ? $_GET['tag'] : null;
              $tagCondition = $tag ? "AND Tags LIKE '%$tag%'" : "";

              $search = isset($_GET['search']) ? mysqli_real_escape_string($db, $_GET['search']) : '';
              $searchCondition = !empty($search) ? "AND (Subiect LIKE '%$search%' OR Text LIKE '%$search%')" : '';
              
              $query = "SELECT * FROM blog WHERE 1 $categoryCondition $tagCondition $searchCondition ORDER BY Nr_articol DESC LIMIT $offset, $limit";
              $result = mysqli_query($db, $query);
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                  $authorQuery = "SELECT Nume, Prenume, Poza FROM utilizatori WHERE ID = '{$row['ID_autor']}'";
                  $authorResult = mysqli_query($db, $authorQuery);
                  if ($authorResult && mysqli_num_rows($authorResult) > 0) {
                    $authorRow = mysqli_fetch_array($authorResult);
                    $gasit = 1;
                  } else {
                    $gasit = 0;
                  }
                  ?>

                  <div class="blog_panel" data-aos="fade-up" data-aos-duration="1500">
                    <div class="main_img">
                      <a href="<?php echo $row["permalink"]; ?>"><img src="images/blog/<?php echo $row["Image"]; ?>"
                          alt="image"></a>
                    </div>

                    <div class="blog_info">
                      <span class="date">
                        <?php echo $row["Data"]; ?>
                      </span>
                      <h2><a href="<?php echo $row["permalink"]; ?>"><?php echo $row["Subiect"]; ?></a></h2>
                      <p>
                        <?php
                        $text = $row["Text"];
                        $limitedText = substr($text, 0, 338);

                        if (strlen($text) > 338) {
                          $limitedText .= "...";
                        }

                        echo $limitedText;
                        ?>
                      </p>
                      <div class="authore_block">
                        <div class="authore">
                          <div class="img">
                            <img src="images/profile/<?php if ($gasit == 1)
                              echo $authorRow['Poza'];
                            else
                              echo 'default.png'; ?>" alt="image">
                          </div>
                          <div class="text">
                            <h4>
                              <?php echo $authorRow["Nume"] . ' ' . $authorRow["Prenume"]; ?>
                            </h4>
                            <span>Autor</span>
                          </div>
                        </div>
                        <div class="blog_tag">
                          <span>
                            <?php echo $row["Categorie"]; ?>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                }
              } ?>

            </div>
          </div>
          <div class="col-lg-4">
            <div class="blog_right_side">
              <div class="blog_search_block bg_box" data-aos="fade-up" data-aos-duration="1500">
                <form action="" method="GET">
                  <div class="form-group">
                    <h3>Caută o postare</h3>
                    <div class="form_inner">
                      <input type="text" class="form-control" name="search"
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                      <button type="submit"><i class="icofont-search-1"></i></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="recent_post_block bg_box" data-aos="fade-up" data-aos-duration="1500">
                <h3>Postări recente</h3>
                <ul class="recent_blog_list">
                  <?php
                  include_once("config/config.php");
                  $query = "SELECT * FROM blog ORDER BY Data DESC LIMIT 4";
                  $result = mysqli_query($db, $query);
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                      $blogDate = $row["Data"];

                      $currentDate = new DateTime();
                      $blogPostedDate = new DateTime($blogDate);

                      $interval = $currentDate->diff($blogPostedDate);
                      $daysAgo = $interval->days;
                      ?>

                      <li>
                        <a href="<?php echo $row["permalink"]; ?>">
                          <div class="img">
                            <img src="images/blog/<?php echo $row["Image"]; ?>" width="70" alt="image">
                          </div>
                          <div class="text">
                            <h4>
                              <?php echo $row["Subiect"]; ?>
                            </h4>
                            <?php
                            if ($daysAgo == 0)
                              echo '<span>Astăzi</span>';
                            else
                              echo '<span>Acum ' . $daysAgo . ' zile</span>';
                            ?>
                          </div>
                        </a>
                      </li>
                      <?php
                    }
                  } ?>
                </ul>
              </div>
              <div class="categories_block bg_box" data-aos="fade-up" data-aos-duration="1500">
                <h3>Categorii</h3>
                <ul>
                  <?php
                  $sql = "SELECT Categorie, COUNT(*) as Count FROM blog GROUP BY Categorie";
                  $result = $db->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      $category = $row['Categorie'];
                      $count = $row['Count'];
                      ?>
                      <li>
                        <a href="?category=<?php echo $category; ?>" class="cat"><i class="icofont-folder-open"></i>
                          <?php echo $category; ?>
                        </a>
                        <span>(
                          <?php echo $count; ?>)
                        </span>
                      </li>
                      <?php
                    }
                  }
                  ?>
                </ul>
              </div>
              <div class="tags_block bg_box" data-aos="fade-up" data-aos-duration="1500">
                <h3>Tag-uri</h3>
                <ul>
                  <?php
                  $sql = "SELECT Tags FROM blog WHERE Tags IS NOT NULL AND Tags <> ''";
                  $result = $db->query($sql);

                  $tagCounts = [];

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      $tags = explode(',', $row['Tags']);
                      foreach ($tags as $tag) {
                        $tag = trim($tag);
                        if (!empty($tag)) {
                          if (!isset($tagCounts[$tag])) {
                            $tagCounts[$tag] = 1;
                          } else {
                            $tagCounts[$tag]++;
                          }
                        }
                      }
                    }
                  }

                  arsort($tagCounts);

                  foreach ($tagCounts as $tag => $count) {
                    ?>
                    <li><a href="?tag=<?php echo $tag; ?>"><?php echo $tag; ?></a></li>
                    <?php
                  }
                  ?>
                </ul>
              </div>


            </div>
          </div>
        </div>

        <div class="pagination_block" data-aos="fade-up" data-aos-duration="1500">
          <div class="row">
            <div class="col-lg-8">
              <ul>
                <?php
                $category = isset($_GET['category']) ? $_GET['category'] : "";

                $query = "SELECT COUNT(*) as total FROM blog";
                if (!empty($category)) {
                  $query .= " WHERE Categorie = '$category'";
                }
                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_assoc($result);
                $totalPages = ceil($row['total'] / $limit);
                $maxPageLinks = 10;

                $startPage = max(1, $page - floor($maxPageLinks / 2));
                $endPage = min($startPage + $maxPageLinks - 1, $totalPages);

                if ($page > 1) {
                  echo '<li><a href="?page=' . ($page - 1) . '&category=' . $category . '" class="prev"><i class="icofont-double-left"></i></a></li>';
                } else {
                  echo '<li><a href="#" class="prev"><i class="icofont-double-left"></i></a></li>';
                }

                for ($i = $startPage; $i <= $endPage; $i++) {
                  if ($i == $page) {
                    echo '<li><a href="?page=' . $i . '&category=' . $category . '&tag=' . $tag . '&search=' . urlencode($search) . '" class="active">' . $i . '</a></li>';
                } else {
                    echo '<li><a href="?page=' . $i . '&category=' . $category . '&tag=' . $tag . '&search=' . urlencode($search) . '">' . $i . '</a></li>';
                }
                }

                if ($page < $totalPages) {
                  echo '<li><a href="?page=' . ($page + 1) . '&category=' . $category . '" class="next"><i class="icofont-double-right"></i></a></li>';
                } else {
                  echo '<li><a href="#" class="next"><i class="icofont-double-right"></i></a></li>';
                }
                ?>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </section>

    <?php include 'config/footer.php' ?>

  </div>

  <script src="js/jquery.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
</body>

</html>