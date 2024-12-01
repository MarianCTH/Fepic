<?php
require_once '../config/config.php';
require_once 'php/config/config-admin.php';
session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}
$current_page = "Chat";
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
                                <h4 class="text-capitalize breadcrumb-title">Configurare Chat BOT</h4>
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
                        <div class="col-lg-12 mb-30">
                            <div class="action-btn">
                                <a href="#" class="btn px-15 btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#new-answer">
                                    <i class="las la-plus fs-16"></i>Adaugă Răspuns</a>

                                <div class="modal fade new-member" id="new-answer" role="dialog" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content radius-xl">
                                            <div class="modal-header">
                                                <h6 class="modal-title fw-500" id="staticBackdropLabel">Adaugă
                                                    Răspuns</h6>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <img src="img/svg/x.svg" alt="x" class="svg">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="new-member-modal">
                                                    <form method="POST" id="addIntentForm">
                                                        <div class="form-group mb-20">
                                                            <input type="text" class="form-control" name="Word"
                                                                placeholder="Cuvânt" required>
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <textarea class="form-control" name="Answer"
                                                                placeholder="Răspuns" required></textarea>
                                                        </div>
                                                        <span>În momentul detectării cuvântului bot-ul o să răspundă cu
                                                            această propoziție.</span>

                                                        <div class="button-group d-flex pt-25">
                                                            <button
                                                                class="btn btn-primary btn-default btn-squared text-capitalize"
                                                                type="submit">Adaugă</button>
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
                            <div class="card mt-30">
                                <div class="card-body">
                                    <div
                                        class="userDatatable adv-table-table global-shadow border-light-0 w-100 adv-table">
                                        <div class="table-responsive">
                                            <table class="table mb-0 table-borderless" data-sorting="true"
                                                data-paging-position="right" data-paging-size="10">
                                                <thead>
                                                    <tr class="userDatatable-header">
                                                        <th>
                                                            <span class="userDatatable-title">Cuvant</span>
                                                        </th>
                                                        <th>
                                                            <span class="userDatatable-title">Raspuns</span>
                                                        </th>
                                                        <th>
                                                            <span class="userDatatable-title float-end">acțiune</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                    <?php
                                                    $intentResponses = json_decode(file_get_contents('../js/json/intent_responses.json'), true);

                                                    foreach ($intentResponses as $intent => $response) {
                                                        echo '<tr class="data-row" id="' . htmlspecialchars($intent, ENT_QUOTES) . '">';
                                                        echo '<td><div class="userDatatable-content">' . $intent . '</div></td>';
                                                        echo '<td><div class="d-flex"><div class="userDatatable-inline-title"><a href="#" class="text-dark fw-500"><h6>' . $response . '</h6></a></div></div></td>';
                                                        echo '<td><ul class="orderDatatable_actions mb-0 d-flex flex-wrap">';

                                                        echo '<li><a href="#" class="remove" onclick="confirmDelete(\'' . htmlspecialchars($intent, ENT_QUOTES) . '\')"><i class="uil uil-trash-alt"></i></a></li>';
                                                        echo '</ul></td>';
                                                        echo '</tr>';
                                                    }
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
                                                            <p>Sigur dorești să ștergi acest răspuns?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm confirm-remove">Confirm</button>
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm cancel-remove"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal succes -->
                                            <div class="modal-info-success modal fade show" id="modal-info-success"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-info" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="modal-info-body d-flex">
                                                                <div class="modal-info-icon success">
                                                                    <img src="img/svg/check-circle.svg"
                                                                        alt="check-circle" class="svg">
                                                                </div>
                                                                <div class="modal-info-text">
                                                                    <p>Răspunsurile au fost actualizate cu succes !</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                data-bs-dismiss="modal">Ok</button>
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
        function confirmDelete(intent) {
            const modal = new bootstrap.Modal(document.getElementById("modal-basic"));
            const confirmButton = document.querySelector(".confirm-remove");

            confirmButton.addEventListener("click", async () => {
                try {
                    const formData = new FormData();
                    formData.append('intent', intent);

                    const response = await fetch("php/chatbot/delete_intent.php", {
                        method: "POST",
                        body: formData,
                    });

                    if (response.ok) {
                        const rowToDelete = document.getElementById(intent);
                        if (rowToDelete) {
                            rowToDelete.remove();
                        }
                    } else {
                        console.error("Failed to delete intent");
                    }
                } catch (error) {
                    console.error("Error deleting intent:", error);
                }

                modal.hide();
            });

            modal.show();
        }

        document.addEventListener("DOMContentLoaded", () => {

            const addIntentForm = document.getElementById("addIntentForm");

            addIntentForm.addEventListener("submit", async (event) => {
                event.preventDefault();

                const wordInput = addIntentForm.querySelector("input[name='Word']");
                const answerInput = addIntentForm.querySelector("textarea[name='Answer']");

                const word = wordInput.value;
                const answer = answerInput.value;

                const data = { [word]: answer };

                try {
                    const response = await fetch("php/chatbot/update_intent_responses.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(data),
                    });

                    if (response.ok) {
                        const tableBody = document.getElementById("tableBody");
                        const newRow = document.createElement("tr");
                        newRow.classList.add("data-row");
                        newRow.id = word;

                        newRow.innerHTML = `
                    <td><div class="userDatatable-content">${word}</div></td>
                    <td><div class="d-flex"><div class="userDatatable-inline-title"><a href="#" class="text-dark fw-500"><h6>${answer}</h6></a></div></div></td>
                    <td><ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                        <li><a href="#" class="remove" onclick="confirmDelete('${word}')"><i class="uil uil-trash-alt"></i></a></li>
                    </ul></td>`;

                        tableBody.appendChild(newRow);
                        $('#new-answer').modal('hide');
                        $('#modal-info-success').modal('show');
                        console.log("Response added successfully!");
                        wordInput.value = "";
                        answerInput.value = "";
                    } else {
                        console.error("Failed to add response");
                    }
                } catch (error) {
                    console.error("Error:", error);
                }
            });
        });
    </script>

</body>

</html>