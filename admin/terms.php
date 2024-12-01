<?php
require_once '../config/config.php';
require_once 'php/config/config-admin.php';

session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}
$current_page = "Terms";
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
    <style>
        .terms-content__group {
            position: relative;
            border: 1px solid transparent;
            transition: border-color 0.3s;
        }

        .terms-content__group:hover {
            border-color: #007bff;
        }

        .edit-button,
        .delete-button {
            margin: 0 5px;
            display: inline-block;

            opacity: 0;
            transition: opacity 0.3s;
        }

        .terms-content__group:hover .edit-button,
        .terms-content__group:hover .delete-button {
            opacity: 1;
        }

        .button-container {
            display: inline;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            /* Adjust other styles as needed */
        }

        .back-page {
            /* Adjust styles for the left element */
        }

        .action-btn {
            /* Adjust styles for the right element */
        }
    </style>
</head>

<body class="layout-light side-menu">
    <div class="mobile-author-actions"></div>
    <?php require_once $config_file . 'header.php'; ?>
    <main class="main-content">
    <?php require_once $config_file . 'sidebar.php'; ?>
        <div class="contents">
            <div class="terms">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-main">
                                <h3 class="text-capitalize breadcrumb-title">Termeni &amp; Condiții</h3>
                                <div class="breadcrumb-action justify-content-center flex-wrap">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#"><i
                                                        class="uil uil-estate"></i>Acasă</a></li>
                                            <li class="breadcrumb-item"><a href="#">Pagini</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Termeni &amp;
                                                Condiții</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="terms-breadcrumb">
                                <div class="display-1">
                                    Termeni & Condiții
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-50">
                        <div class="header-container">
                            <div class="back-page">
                                <a href="../terms"><img src="img/svg/arrow-left.svg" alt="arrow-left"
                                        class="svg">Termeni și condiții</a>
                            </div>
                            <div class="action-btn">
                                <a href="#" class="btn px-15 btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#new-term">
                                    <i class="las la-plus fs-16"></i>Adaugă Termen</a>
                                <div class="modal fade new-member" id="new-term" role="dialog" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content radius-xl">
                                            <div class="modal-header">
                                                <h6 class="modal-title fw-500" id="staticBackdropLabel">Adaugă
                                                    Termen sau condiție</h6>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    id="close-modal-term" aria-label="Close">
                                                    <img src="img/svg/x.svg" alt="x" class="svg">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="new-member-modal">
                                                    <form method="POST" id="addIntentForm">
                                                        <div class="form-group mb-20">
                                                            <input type="text" class="form-control" name="Title"
                                                                placeholder="Titlu" required>
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <textarea class="form-control" name="Content"
                                                                placeholder="Conținut" required></textarea>
                                                        </div>

                                                        <div class="button-group d-flex pt-25">
                                                            <button
                                                                class="btn btn-primary btn-default btn-squared text-capitalize"
                                                                type="submit" id="add-term">Adaugă</button>
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
                        <div class="col-xxl-6 col-sm-8 col-10">

                            <div class="terms-content" id="terms-content">
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
        const termsContent = document.getElementById("terms-content");
        let sectionContent;

        var addTerm = document.getElementById("add-term");

        addTerm.addEventListener("click", function (event) {
            event.preventDefault();

            const titleInput = document.querySelector('input[name="Title"]');
            const contentInput = document.querySelector('textarea[name="Content"]');

            const newTerm = {
                title: titleInput.value,
                content: contentInput.value
            };

            fetch('php/terms/add_term.php', {
                method: 'POST',
                body: JSON.stringify(newTerm),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    var closeButton = document.getElementById("close-modal-term");
                    closeButton.click();

                    const sectionDiv = document.createElement("div");
                    sectionDiv.className = "terms-content__group";

                    const sectionTitle = document.createElement("h1");
                    sectionTitle.textContent = newTerm.title;

                    sectionContent = document.createElement("p");
                    sectionContent.textContent = newTerm.content;

                    sectionDiv.appendChild(sectionTitle);
                    sectionDiv.appendChild(sectionContent);

                    // Insert the new term before the existing content
                    termsContent.insertBefore(sectionDiv, termsContent.firstChild);

                    titleInput.value = "";
                    contentInput.value = "";
                })
                .catch(error => {
                    console.error('Error adding term:', error);
                });
        });

        fetch('../js/json/terms_conditions.json')
            .then(response => response.json())
            .then(jsonContent => {
                jsonContent.sections.forEach((section, index) => {
                    const sectionDiv = document.createElement("div");
                    sectionDiv.className = "terms-content__group";

                    const sectionTitle = document.createElement("h1");
                    sectionTitle.textContent = section.title;

                    sectionContent = document.createElement("p");
                    sectionContent.textContent = section.content;

                    sectionDiv.appendChild(sectionTitle);
                    sectionDiv.appendChild(sectionContent);

                    const editButton = document.createElement("button");
                    editButton.className = "edit-button btn btn-primary btn-default btn-squared btn-transparent-primary";
                    editButton.innerHTML = "<span class='uil uil-edit' style = 'margin-right: 0px !important;'></span>";
                    editButton.addEventListener("click", () => {
                        const sectionContentElement = sectionDiv.querySelector('p');

                        editButton.style.display = "none";
                        deleteButton.style.display = "none";
                        sectionContentElement.contentEditable = true;

                        const saveButton = document.createElement("button");
                        saveButton.className = "save-button btn btn-success btn-default btn-squared btn-transparent-success";
                        saveButton.innerHTML = "<span class='uil uil-check-circle' style='margin-right: 0px !important;'></span";

                        saveButton.addEventListener("click", async () => {
                            try {
                                const editedContent = sectionContentElement.textContent;

                                const response = await fetch(`php/terms/edit_terms.php?index=${index}&content=${editedContent}`, {
                                    method: 'POST'
                                });

                                if (response.ok) {
                                    const data = await response.json();
                                    console.log(data.message);

                                    editButton.style.display = "inline-block";
                                    deleteButton.style.display = "inline-block";
                                    saveButton.style.display = "none";
                                    sectionContentElement.contentEditable = false;

                                } else {
                                    const errorData = await response.json();
                                    console.error(errorData.error);
                                }
                            } catch (error) {
                                console.error('Error saving section:', error.message);
                            }
                        });

                        sectionDiv.appendChild(saveButton);
                    });


                    const deleteButton = document.createElement("button");
                    deleteButton.className = "delete-button btn btn-danger btn-default btn-squared btn-transparent-danger ";
                    deleteButton.innerHTML = "<span class='uil uil-times-circle' style = 'margin-right: 0px !important;'></span>";
                    deleteButton.addEventListener("click", async () => {
                        const confirmed = confirm("Are you sure you want to delete this section?");

                        if (confirmed) {
                            const sectionDiv = deleteButton.closest('.terms-content__group');
                            sectionDiv.remove();

                            const indexToDelete = index;

                            (async () => {
                                try {
                                    const response = await fetch(`php/terms/delete_terms.php?index=${indexToDelete}`, {
                                        method: 'DELETE'
                                    });

                                    if (response.ok) {
                                        const data = await response.json();
                                        console.log(data.message);
                                    } else {
                                        const errorData = await response.json();
                                        console.error(errorData.error);
                                    }
                                } catch (error) {
                                    console.error('Error deleting section:', error);
                                }
                            })();
                        }
                    });


                    const buttonContainer = document.createElement("div");
                    buttonContainer.className = "button-container";
                    buttonContainer.appendChild(editButton);
                    buttonContainer.appendChild(deleteButton);

                    sectionDiv.appendChild(buttonContainer);

                    termsContent.appendChild(sectionDiv);
                });

                const lastUpdated = document.createElement("div");
                lastUpdated.className = "terms-content__update";
                lastUpdated.innerHTML = `<p>Ultima actualizare: ${jsonContent.last_updated}</p>`;

                termsContent.appendChild(lastUpdated);
            })
            .catch(error => {
                console.error('Error fetching JSON:', error);
            });

    </script>


</body>

</html>