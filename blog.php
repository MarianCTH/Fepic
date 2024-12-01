<?php
include_once("config/config.php");
header("Content-type: text/html; charset=UTF-8");

if (!isset($_GET['id']))
  header("Location: error.php");
else
  $id = $_GET['id'];

$postQuery = "SELECT blog.*, utilizatori.*
              FROM blog
              JOIN utilizatori ON blog.ID_autor = utilizatori.ID
              WHERE blog.Nr_articol = ?";
$stmt = mysqli_prepare($db, $postQuery);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$postResult = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($postResult);
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php echo $post['Subiect']; ?>
  </title>

  <link rel="stylesheet" href="css/icofont.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="css/modal.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <meta property="og:site_name" content="FEPIC" />
  <meta property="og:title" content="<?php echo $post['Subiect']; ?>" />
  <meta property="og:description" content="<?php echo substr($post['Text'], 0, 100); ?>..." />
  <meta property="og:image" content="https://fepic.zappnet.ro/images/blog/<?php echo $post['Image']; ?>" />
  <meta property="og:url" content="https://fepic.zappnet.ro/blog/?id=<?php echo $id; ?>" />
  <meta property="og:type" content="article" />
  <style>
    .hidden-comment {
      display: none;
    }

    .comment-author-image {
      height: 3.125rem;
      border-radius: 50% !important;
    }

    i {
      line-height: inherit !important;
    }

    #tags {

      background-color: var(--main_purple);
      color: var(--text-white);
      display: inline-block;
      padding: 3px 20px;
      border-radius: 50px;
      line-height: 1.5;
      margin-right: 0.5rem;
    }

    .blog_authore {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .like-button {
      background-color: none;
      border: none;
      cursor: pointer;
    }

    .like-button i.icofont-heart {}

    .like-button2.liked {
      background-color: #c53535;
      border-color: #c53535;
      color: var(--text-white);
    }

    .social-icons {
      position: relative;
      display: inline-block;
      /* Add this line */
    }

    .social-icons-hover {
      position: absolute;
      top: 100%;
      left: 50%;
      transform: translateX(-50%);
      display: none;
      text-align: center;
      /* Add this line */
    }

    .social-icons:hover .social-icons-hover {
      display: block;
    }

    .social-icons-hover a {
      display: inline-block;
      margin: 5px;
      color: #000;
      /* Change color as needed */
      font-size: 20px;
      /* Change font size as needed */
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

      <?php
      $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
      $db->set_charset("utf8mb4");

      if ($db === false) {
        die("EROARE: Nu s-a putut face conexiunea la baza de date. pentru suport va rugam sa scrieti un tichet pe my.zapptelecom.ro sau support@zappnet.ro " . mysqli_connect_error());
      }
      if (mysqli_num_rows($postResult) > 0) {
        $currentViews = $post['Vizualizari'];
        $articleId = $post['Nr_articol'];
        $newViews = $currentViews + 1;
        $sql = "UPDATE blog SET Vizualizari = $newViews WHERE Nr_articol = $articleId";
        $db->query($sql);
        ?>
        <div class="bread_crumb" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
          <div class="container">
            <div class="bred_text">
              <h2>
                <?php echo $post['Subiect']; ?>
              </h2>
              <ul>
                <li><a href="">Acasă</a></li>
                <li><span>»</span></li>
                <li><a href="">Blog</a></li>
              </ul>
            </div>
          </div>
        </div>

      </div>

      <section class="blog_detail_section" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200">
        <div class="container">
          <div class="blog_inner_pannel">
            <div class="blog_info" data-aos="fade-up" data-aos-duration="2000">
              <div class="authore_block" data-aos="fade-up" data-aos-duration="1000">
                <div class="authore">
                  <div class="img">
                    <img src="images/profile/<?php echo $post['Poza']; ?>" alt="image">
                  </div>
                  <div class="text">

                    <h4>
                      <?php echo $post['Nume'] . ' ' . $post['Prenume']; ?>
                    </h4>
                    <span class="date">
                      <?php echo $post['Data']; ?>
                    </span>
                  </div>
                </div>
                <div class="blog_tag">
                  <span>
                    <?php echo $post['Categorie']; ?>
                  </span>
                </div>
              </div>
            </div>
            <div class="main_img" data-aos="fade-up" data-aos-duration="1500">
              <img src="images/blog/<?php echo $post['Image']; ?>" alt="image">
            </div>
            <div class="info" data-aos="fade-up" data-aos-duration="1500">
              <h2>
                <?php echo $post['Subiect']; ?>
              </h2>
              <p>
                <?php echo $post['Text']; ?>
              </p>

              <?php
              if (!empty($post['Tags'])) {
                $tags = explode(', ', $post['Tags']);
                foreach ($tags as $tag) {
                  echo '<span id="tags">#' . $tag . '</span>';
                }
              }
              ?>

            </div>
            <div class="blog_authore" data-aos="fade-up" data-aos-duration="1500">
              <div class="social_media">
                <h3>Interacțiuni</h3>
                <ul>
                  <?php
                  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                    ?>
                    <li><a href="" class="like-button2"><i class="icofont-heart"></i></a></li>
                    <?php
                    if ($post['Comentarii'] == 1) {
                      echo '<li><a href="#comment_form_section"><i class="icofont-comment"></i></a></li>';
                    }
                  } else {
                    ?>
                    <li><a href="sign-in.php"><i class="icofont-heart"></i></a></li>
                    <?php
                    if ($post['Comentarii'] == 1) {
                      echo '<li><a href="sign-in.php"><i class="icofont-comment"></i></a></li>';
                    }
                  }
                  ?>
                  <li class="social-icons">
                    <a><i class="icofont-share"></i></a>
                    <div class="social-icons-hover">
                      <a href="#" onclick="shareOnFacebook()"><i class="icofont-facebook"></i></a>
                      <a href="#" onclick="shareOnInstagram()"><i class="icofont-instagram"></i></a>
                      <a href="#" onclick="shareOnTwitter()"><i class="icofont-twitter"></i></a>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php if ($post['Comentarii'] == 1) { ?>
        <section class="row_am comment_section" id="comment">
          <div class="container">
            <div class="blog_cooment_block">
              <div class="posted_cooment">
                <?php
                $stmt = $db->prepare("SELECT COUNT(*) AS count FROM comentarii_postare WHERE ID_postare = ?");
                $stmt->bind_param("s", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $nr_of_comments = $row['count'];
                ?>
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500">
                  <h2 id="nr_of_comms">
                    <?php
                    if ($nr_of_comments > 1)
                      echo $nr_of_comments . ' Comentarii';
                    else if ($nr_of_comments == 0)
                      echo 'Nici un comentariu';
                    else
                      echo 'Un comentariu'; ?>
                  </h2>
                </div>

                <ul id="commentList">
                  <?php
                  $stmt = $db->prepare("SELECT * FROM comentarii_postare WHERE ID_postare = ? LIMIT 5");
                  $stmt->bind_param("s", $id);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  while ($row = $result->fetch_assoc()) {
                    $authorcom = $row['Autor'];

                    $profilepic2 = "SELECT * FROM utilizatori WHERE Nume = ?";
                    $stmtp2 = mysqli_prepare($db, $profilepic2);
                    mysqli_stmt_bind_param($stmtp2, 's', $authorcom);
                    mysqli_stmt_execute($stmtp2);
                    $profilePicture2 = mysqli_stmt_get_result($stmtp2);
                    $profilep2 = mysqli_fetch_assoc($profilePicture2);

                    $timePosted = strtotime($row['Data']);
                    $currentTime = time();
                    $elapsedTime = $currentTime - $timePosted;

                    if ($elapsedTime >= 86400 * 365) {
                      $updatedTime = "Acum " . floor($elapsedTime / (86400 * 365)) . " ani";
                    } elseif ($elapsedTime >= 86400) {
                      $updatedTime = "Acum " . floor($elapsedTime / 86400) . " zile";
                    } elseif ($elapsedTime >= 3600) {
                      $updatedTime = "Acum " . floor($elapsedTime / 3600) . " ore";
                    } elseif ($elapsedTime >= 60) {
                      $updatedTime = "Acum " . floor($elapsedTime / 60) . " minute";
                    } elseif ($elapsedTime >= 1) {
                      $updatedTime = "Acum " . $elapsedTime . " secunde";
                    } else {
                      $updatedTime = "Chiar acum";
                    }
                    ?>
                    <li data-aos="fade-up" data-aos-duration="1500">
                      <div class="authore_info">
                        <div class="avtar">
                          <img src="images/profile/<?php echo $profilep2['Poza']; ?>" class="comment-author-image"
                            alt="image">
                        </div>
                        <div class="text">
                          <span id="<?php echo $timePosted; ?>">
                            <?php echo $updatedTime; ?>
                          </span>
                          <h4>
                            <?php echo $row['Autor']; ?>
                          </h4>
                        </div>
                      </div>
                      <div class="comment">
                        <p>
                          <?php echo $row['Comentariu']; ?>
                        </p>
                      </div>
                    </li>
                    <?php
                  }
                  $stmt->close(); ?>

                </ul>
                <div class="container text-center" style="margin-top:1rem;">
                  <div class="row align-items-start">
                    <div class="col">
                      <?php
                      if ($nr_of_comments > 5) { ?>
                        <div data-aos="fade-up" data-aos-duration="1500"><button type="button"
                            class="btn btn_main btn-sm load-more-button" data-page="2">Încarcă mai multe comentarii</button>
                        </div>
                        <?php
                      } ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="comment_form_section" id="comment_form_section">
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500">
                  <h2>Lasă un <span>comentariu</span></h2>
                  <p>După postare comentariul tău va deveni public.</p>
                </div>
                <form id="commentForm" method="POST" data-aos="fade-up" data-aos-duration="1500">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <textarea maxlength="50" class="form-control" name="comment" placeholder="Comentariu"
                          required></textarea>
                      </div>
                    </div>
                    <div class="col-md-12 text-left">
                      <button class="btn btn_main" type="button" id="submitComment">Postează<i
                          class="icofont-arrow-right"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>

        <div class="modal-info-success modal fade show" id="modal-info-success" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-info" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <div class="modal-info-body d-flex">
                  <div class="modal-info-icon primary">
                    <img src="admin/img/svg/alert-circle.svg" alt="alert-circle" class="svg">
                  </div>
                  <div class="modal-info-text">
                    <p></p>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Ok</button>
              </div>
            </div>
          </div>
        </div>
        <?php

      }
      mysqli_close($db);
      }

      include 'config/footer.php'; ?>

  </div>

  <script src="js/jquery.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <script>
    $(document).ready(function () {
      var postId = <?php echo $id; ?>;
      var button = $('.like-button2');

      $.ajax({
        url: 'php/blog/check-like.php',
        method: 'POST',
        data: { post_id: postId },
        dataType: 'json',
        success: function (response) {
          if (response.liked) {
            button.addClass('liked');
          }
        }
      });

      button.on('click', function (event) {
        event.preventDefault();

        button.toggleClass('liked');
        if (button.hasClass('liked')) {
          $.ajax({
            url: 'php/blog/like.php',
            method: 'POST',
            data: { post_id: postId, action: 'like' },
            dataType: 'json',
            success: function (response) {
            }
          });
        } else {
          $.ajax({
            url: 'php/blog/like.php',
            method: 'POST',
            data: { post_id: postId, action: 'unlike' },
            dataType: 'json',
            success: function (response) {
            }
          });
        }
      });
    });

    function shareOnFacebook() {
      const shareUrl = 'https://example.com';
      const shareTitle = 'Example Title';
      const shareDescription = 'Example description';

      const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}&title=${encodeURIComponent(shareTitle)}&description=${encodeURIComponent(shareDescription)}`;
      openNewWindow(facebookUrl);
    }

    function shareOnInstagram() {
      const shareText = 'Example text';

      const instagramUrl = `https://www.instagram.com/share?text=${encodeURIComponent(shareText)}`;
      openNewWindow(instagramUrl);
    }

    function shareOnTwitter() {
      const shareText = 'Example text';
      const shareUrl = 'https://example.com';

      const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText)}&url=${encodeURIComponent(shareUrl)}`;
      openNewWindow(twitterUrl);
    }

    function openNewWindow(url) {
      window.open(url, '_blank', 'width=600,height=400');
    }

  </script>
  <script>
    $(document).ready(function () {
      $('#submitComment').on('click', function (event) {
        event.preventDefault();
        var commentText = $('textarea[name="comment"]').val();

        $.ajax({
          url: 'php/blog/save_comment.php',
          method: 'POST',
          data: { id: <?php echo $id; ?>, comment: commentText },
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              $('textarea[name="comment"]').val('');

              var newComment = '<li data-aos="fade-up" data-aos-duration="1500">' +
                '<div class="authore_info">' +
                '<div class="avtar">' +
                '<img src="images/profile/' + response.profilePicture + '" class="comment-author-image" alt="image">' +
                '</div>' +
                '<div class="text">' +
                '<span>' + response.updatedTime + '</span>' +
                '<h4>' + response.author + '</h4>' +
                '</div>' +
                '</div>' +
                '<div class="comment">' +
                '<p>' + response.comment + '</p>' +
                '</div>' +
                '</li>';

              $('#commentList').append(newComment);
              var nrOfComments = <?php echo $nr_of_comments; ?>;

              var h2Element = document.getElementById("nr_of_comms");

              if (nrOfComments > 1) {
                h2Element.textContent = nrOfComments + 1 + " Comentarii";
              }
              else {
                h2Element.textContent = "Un comentariu";
              }

              $('html, body').animate({
                scrollTop: $('#commentList').offset().top + $('#commentList').outerHeight() - window.innerHeight
              }, 500);
              showModal('Success', response.message);
            } else {
              showModal('Error', response.message);
            }
          },
          error: function () {
            showModal('Error', 'Pentru această acțiune trebuie să vă autentificați.');
          }
        });
      });

      function showModal(status, message) {
        // Set the modal message
        $('#modal-info-success .modal-info-text p').text(message);

        var modalIcon = $('#modal-info-success .modal-info-icon img');
        if (status === 'Success') {
          modalIcon.attr('src', 'admin/img/svg/check-circle.svg');
          modalIcon.attr('alt', 'check-circle');
        } else {
          modalIcon.attr('src', 'admin/img/svg/alert-circle.svg');
          modalIcon.attr('alt', 'alert-circle');
        }

        $('#modal-info-success').modal('show');
      }

    });

    $(document).ready(function () {
      function updateTime() {
        var comments = document.getElementsByClassName('authore_info');
        var currentTime = Math.floor(Date.now() / 1000);

        var minElapsedTime = Infinity;
        for (var i = 0; i < comments.length; i++) {
          var comment = comments[i]; var
            timestampElement = comment.getElementsByTagName('span')[0]; var timestampId = timestampElement.id; var
              timePosted = parseInt(timestampId); var elapsedTime = currentTime - timePosted; if (elapsedTime < minElapsedTime) {
                minElapsedTime = elapsedTime;
              } if (elapsedTime < 60 && elapsedTime >= 10) {
                timestampElement.innerHTML = "Acum " + elapsedTime + " secunde";
              } else if (elapsedTime >= 86400 * 365) {
                timestampElement.innerHTML = "Acum " + Math.floor(elapsedTime / (86400 * 365)) + " ani";
              } else if (elapsedTime >= 86400) {
                timestampElement.innerHTML = "Acum " + Math.floor(elapsedTime / 86400) + " zile";
              } else if (elapsedTime >= 3600) {
                timestampElement.innerHTML = "Acum " + Math.floor(elapsedTime / 3600) + " ore";
              } else if (elapsedTime >= 60) {
                timestampElement.innerHTML = "Acum " + Math.floor(elapsedTime / 60) + " minute";
              } else if (elapsedTime < 10) { timestampElement.innerHTML = "Chiar acum"; }
        } var interval = minElapsedTime < 60 ? 1000
          : 60000; setTimeout(updateTime, interval);
      } updateTime();
    }); </script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      let currentPage = 2;

      document.querySelector(".load-more-button").addEventListener("click", function () {
        const button = this;
        const nextPage = button.getAttribute("data-page");

        const xhr = new XMLHttpRequest();
        xhr.open("GET", `php/blog/load_comments.php?page=${nextPage}&id=<?php echo $id; ?>`, true);

        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            const newComments = xhr.responseText;
            const commentList = document.getElementById("commentList");
            commentList.insertAdjacentHTML("beforeend", newComments);

            button.setAttribute("data-page", parseInt(nextPage) + 1);

            const numberOfNewComments = (newComments.match(/<li/g) || []).length;
            if (numberOfNewComments < 5) {
              button.style.display = "none";
            }
          }
        };

        xhr.send();
      });
    });
  </script>
</body>

</html>