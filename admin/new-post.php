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

$current_page = "Postare Nouă";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetDir = "../images/blog/";
    $error = "";

    $stmt = $db->prepare("INSERT INTO blog (ID_autor, Subiect, Text, Image, ImageIndex, Categorie, Comentarii, Tags, permalink) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $ID_autor, $Subiect, $Text, $Image, $ImageIndex, $Categorie, $Comentarii, $Tags, $permalink);

    $ID_autor = $_SESSION['id'];
    $Subiect = $_POST["subject"];
    $Text = $_POST["content"];
    $permalink = str_replace([' ', '/'], '-', $Subiect);

    if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0) {
        $Image = $_FILES["image"]["name"];
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            error_log('Image uploaded: ' . $Image);
        } else {
            error_log('Error moving the uploaded file');
        }
    } else {
        $Image = "";
        error_log('No image uploaded');
    }
    $ImageIndex = "story-03.png";
    $Categorie = $_POST["category"];
    $Comentarii = isset($_POST['comentarii']) ? 1 : 0;
    $Tags = $_POST["tags"];

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $sql = "SELECT Nr_articol FROM blog WHERE Subiect = '$Subiect'";

        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_postare = $row['Nr_articol'];
            $subject = str_replace([' ', '/'], '-', $Subiect);
        }

        $logMessage = 'Administratorul ' . $_SESSION["username"] . ' ' . $_SESSION["prenume"] . ' [#' . $_SESSION["id"] . '] a postat un nou blog.';
        $htaccessFile = '../.htaccess';

        $lineToAdd = "RewriteRule ^" . $subject . "$ blog.php?id=" . $id_postare . " [L,NC]";

        $htaccessContent = file_get_contents($htaccessFile);

        $search = "RewriteEngine on";
        $replacement = $search . PHP_EOL . $lineToAdd;
        $htaccessContent = str_replace($search, $replacement, $htaccessContent);

        if (file_put_contents($htaccessFile, $htaccessContent)) {
            error_log('The rewrite rule has been added to the .htaccess file.');
        } else {
            error_log('Failed to add the rewrite rule to the .htaccess file.');
        }

        $errorLog = 'error.log';
        if (!file_exists($errorLog)) {
            $file = fopen($errorLog, 'w');
            fclose($file);
        }

        error_log('Logging test message.', 3, $errorLog);
    } else {
        $error = "Error inserting data.";
    }

    $stmt->close();
    $db->close();
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
    <script src="js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
    tinymce.init({
        selector: '#blog-post-content',
        height: 500,
        promotion: false,
        plugins: 'anchor autolink emoticons image link lists media searchreplace visualblocks wordcount checklist mediaembed inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tiny.cloud/css/codepen.min.css'
        ],
        menu: {
            file: { title: 'File', items: 'print' },
        },
        branding: false,
    });
</script>

    <style>
        .button-group {
            margin-bottom: 20px;
        }

        .tox-tinymce {
            min-height: 200px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .hide {
            display: none;
        }

        .dm-upload-avatar:hover {
            background-color: rgb(139 139 139 / 10%);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
    </style>
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
                                <h4 class="text-capitalize breadcrumb-title">Adaugă o postare</h4>
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
                    <div class="row">
                        <div id="form-container">
                            <form id="postForm" method="POST" enctype="multipart/form-data">
                                <div class="dm-upload">
                                    <div class="dm-upload-avatar media-import dropzone-md-s">
                                        <p class="color-light mt-0 fs-14 ">Uploadează banner-ul pentru postare</p>
                                        <img class="uploaded-image">
                                    </div>
                                    <div class="avatar-up">
                                        <input type="file" name="image" class="upload-avatar-input" required>
                                    </div>
                                </div>
                                <div class="card card-horizontal card-default card-md mb-4">
                                    <div class="card-header">
                                        <h6>Subiect</h6>
                                    </div>
                                    <div class="with-icon">

                                        <span class="uil uil-subject"></span>
                                        <input type="text" name="subject"
                                            class="form-control ih-medium ip-lightradius-xs b-light" id="inputNameIcon1"
                                            placeholder="Subiect" required>
                                    </div>
                                </div>
                                <div class="card card-horizontal card-default card-md mb-4">
                                    <div class="card-header">
                                        <h6>Conținut postare</h6>
                                    </div>
                                    <div class="card-body py-md-30">
                                        <textarea name="content" id="blog-post-content"
                                            class="form-control-lg"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12" style="display: flex;">
                                    <div class="card card-default card-md mb-4" style="flex: 1; margin-right: 10px;">
                                        <div class="card-header">
                                            <h6>Activează comentariile</h6>
                                        </div>
                                        <div class="card-body py-md-30">
                                            <div class="form-check form-switch form-switch-primary form-switch-md">
                                                <?php
                                                $_POST['comentarii'] = 1;
                                                $comentariiValue = isset($_POST['comentarii']) ? 1 : 0;
                                                ?>
                                                <input type="checkbox" class="form-check-input" id="switch-s1"
                                                    name="comentarii" <?php echo $comentariiValue == 1 ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="switch-s1"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-default card-md mb-4" style="flex: 1;">
                                        <div class="card-header">
                                            <h6>Repostează pe Facebook, Instagram și Twitter</h6>
                                        </div>
                                        <div class="card-body py-md-30">
                                            <div class="form-check form-switch form-switch-primary form-switch-md">
                                                <input type="checkbox" class="form-check-input" id="switch-s1" checked>
                                                <label class="form-check-label" for="switch-s1"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-default card-md mb-4" style="flex: 1; margin-left: 10px;">
                                        <div class="card-header">
                                            <h6>Tag-uri</h6>
                                        </div>
                                        <div class="card-body py-md-30">
                                            <div class="dm-tag-wrap">
                                                <div class="tag-box" id="tag-box">
                                                </div>
                                            </div>
                                            <input type="text" name="category1" id="tag-input"
                                                class="form-control ih-medium ip-light radius-xs b-light"
                                                id="validationDefault012" placeholder="">
                                        </div>
                                    </div>
                                    <input type="hidden" name="tags" id="tags-input" value="">


                                    <div class="card card-default card-md mb-4" style="flex: 1; margin-left: 10px;">
                                        <div class="card-header">
                                            <h6>Categorie</h6>
                                        </div>
                                        <div class="card-body py-md-30">
                                            <input type="text" name="category"
                                                class="form-control  ih-medium ip-light radius-xs b-light"
                                                id="validationDefault012" placeholder="" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="text-center">
                                    <div class="d-inline-flex button-group">
                                        <button class="btn btn-primary px-30" type="submit">Postează</button>
                                        <button
                                            class="btn btn-secondary px-30 btn-previzualizeaza">Previzualizează</button>
                                    </div>
                                </div>
                            </form>
                            <div id="previewSection" class="hide">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 col-12">
                                        <ul class="blog-details-meta">
                                            <li class="blog-author">
                                                <a href="#">
                                                    <img src="../images/profile/<?php echo $user['Poza']; ?>" alt>
                                                </a>
                                                <a href="#">
                                                    <span id="previewAuthor"></span>
                                                </a>
                                            </li>
                                            <li class="author-name">
                                                <a href="#" rel="bookmark">
                                                    <time id="previewDate" class="entry-date published updated"
                                                        datetime=""></time>
                                                </a>
                                            </li>
                                            <li class="blog-category">
                                                <a id="previewCategory" href="#" rel="category tag"></a>
                                            </li>
                                        </ul>
                                        <div class="blog-details-thumbnail">
                                            <img id="uploaded-imagee" alt>
                                        </div>
                                        <article class="blog-details">
                                            <div class="blog-details-content">
                                                <h1 id="previewSubject" class="main-title mb-30"></h1>
                                                <div class="blog-body"></div>
                                                <div class="blog-tags">
                                                    <ul id="previewTags">
                                                    </ul>
                                                </div>

                                            </div>
                                        </article>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="d-inline-flex button-group">
                                        <button id="editButton" class="btn btn-primary px-30">Ieși din modul de
                                            previzualizare</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" style="display:none !important;" class="btn-outline-lighten"
                            data-bs-toggle="modal" data-bs-target="#modal-info">Info</button>
                        <div class="modal-info modal fade show" id="modal-info" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-info" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="modal-info-body d-flex">
                                            <div class="modal-info-icon primary">
                                                <img src="img/svg/alert-circle.svg" alt="alert-circle" class="svg">
                                            </div>
                                            <div class="modal-info-text">
                                                <p>Nu poți să previzualizezi fără a completa subiectul, textul și
                                                    imaginea.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Am
                                            înțeles</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" style="display:none !important;"
                            class="btn btn-outline-lighten btn-outline-lighten__height btn_succes"
                            data-bs-toggle="modal" data-bs-target="#modal-info-success">Success</button>
                        <div class="modal-info-success modal fade show" id="modal-info-success" tabindex="-1"
                            role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-info" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="modal-info-body d-flex">
                                            <div class="modal-info-icon success">
                                                <img src="img/svg/check-circle.svg" alt="check-circle" class="svg">
                                            </div>
                                            <div class="modal-info-text">
                                                <p>Postarea a fost publicată cu succes</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Am
                                            înțeles</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="js/plugins.min.js"></script>
    <script src="js/script.min.js"></script>
    <script>
        const tagInput = document.getElementById('tag-input');
        const tagBox = document.getElementById('tag-box');

        const tagsArray = [];

        function updateTagsInput() {
            document.getElementById('tags-input').value = tagsArray.join(', ');
        }

        tagInput.addEventListener('keydown', function (event) {
            if (event.code === 'Space' && !event.shiftKey) {
                event.preventDefault();

                const tagName = tagInput.value.trim();

                if (tagName !== '') {
                    const tagElement = document.createElement('span');
                    tagElement.classList.add('dm-tag', 'tag-light');
                    tagElement.textContent = tagName;

                    const closeButton = document.createElement('a');
                    closeButton.classList.add('tag-closable');
                    closeButton.innerHTML = '<i class="la la-times"></i>';

                    closeButton.addEventListener('click', function () {
                        tagElement.remove();
                        const index = tagsArray.indexOf(tagName);
                        if (index > -1) {
                            tagsArray.splice(index, 1);
                            updateTagsInput();
                            updateCurrentTags();
                        }
                    });

                    tagElement.appendChild(closeButton);
                    tagBox.appendChild(tagElement);

                    tagsArray.push(tagName);
                    updateTagsInput();
                    tagInput.value = '';
                }
            }
        });
        const inputFile = document.querySelector('.upload-avatar-input');
        const uploadedImage = document.querySelector('.uploaded-image');

        inputFile.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const imageURL = e.target.result;

                    uploadedImage.src = imageURL;
                    uploadedImage.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                uploadedImage.src = '';
                uploadedImage.style.display = 'none';
            }
        });

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var previzualizeazaButton = document.querySelector(".btn-previzualizeaza");
            previzualizeazaButton.addEventListener("click", function (event) {
                event.preventDefault();

                var subject = document.querySelector("input[name='subject']").value;
                var content = tinymce.get("blog-post-content").getContent();
                var imageSrc = document.querySelector("input[name='image']").value.trim();

                if (subject.trim() === "" || content.trim() === "" || imageSrc === "") {
                    var invisibleButton = document.querySelector(".btn-outline-lighten");
                    invisibleButton.click();
                } else {
                    var author = "<?php echo $_SESSION['username']; ?>";
                    var currentDate = new Date();
                    var date = currentDate.toLocaleDateString();
                    var category = document.querySelector("input[name='category']").value;
                    var tags = document.querySelector("input[name='tags']").value;
                    var fileInput = document.querySelector("input[name='image']");
                    var file = fileInput.files[0];

                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var uploadedImage = document.getElementById("uploaded-imagee");
                        uploadedImage.src = e.target.result;
                    };

                    reader.readAsDataURL(file);

                    document.getElementById("previewSubject").textContent = subject;
                    document.getElementById("previewAuthor").textContent = author;
                    document.getElementById("previewDate").textContent = date;
                    document.getElementById("previewCategory").textContent = category;
                    document.getElementById("previewTags").innerHTML = "<span class='dm-tag tag-primary tag-transparented'>" + tags.split(",").join("</span><span class='dm-tag tag-primary tag-transparented'>") + "</span>";
                    document.querySelector(".blog-body").innerHTML = content;

                    document.getElementById("previewSection").classList.remove("hide");

                    document.getElementById("postForm").classList.add("hide");
                }
            });

            var editButton = document.getElementById("editButton");
            editButton.addEventListener("click", function () {
                document.getElementById("previewSection").classList.add("hide");
                document.getElementById("postForm").classList.remove("hide");
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#postForm").submit(function (event) {
                event.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "new-post.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        var invisibleButton = document.querySelector(".btn_succes");
                        invisibleButton.click();
                    },
                    error: function () {
                        alert("An error occurred.");
                    }
                });
            });
        });
    </script>

</body>

</html>