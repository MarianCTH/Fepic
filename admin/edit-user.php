<?php
$id = $_GET['id'];
if (!isset($id) || !is_numeric($id)) {
    header("Location: ../error.php");
}

require_once '../config/config.php';
require_once 'php/config/config-admin.php';

session_start();
$current_page = "Utilizatori";

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT u.Nume, u.Prenume, u.Email, u.TipCont, u.Status, u.Rol, u.Poza, d.Adresă, d.Data_nasterii, d.Companie, d.`Rol Companie`, d.Telefon, d.CUI
          FROM utilizatori u
          JOIN date_utilizatori d ON u.id = d.ID_utilizator
          WHERE u.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->bind_result($name, $prenume, $email, $tipCont, $status, $role2, $poza, $address, $birthdate, $company, $role, $phone, $CUI);

    $stmt->fetch();

    $stmt->close();
} else {
}

$conn->close();


if (isset($_POST['personal_info_submit'])) {
    $updatedName = $_POST['name1'];
    $updatedPrenume = $_POST['prenume1'];
    $updatedEmail = $_POST['email1'];
    $updatedPhone = $_POST['phone'];
    $updatedBirthdate = $_POST['dob'];
    $updatedAddress = $_POST['address'];

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $conn->set_charset("utf8mb4");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "UPDATE utilizatori u
              JOIN date_utilizatori d ON u.id = d.ID_utilizator
              SET u.Nume = ?, u.Prenume = ?, u.Email = ?, d.Adresă = ?, d.Data_nasterii = ?, d.Telefon = ?
              WHERE u.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $updatedName, $updatedPrenume, $updatedEmail, $updatedAddress, $updatedBirthdate, $updatedPhone, $id);

    $stmt->execute();
    logMessage('Profilul (Date Personale) utilizatorului ' . $name . ' ' . $prenume . ' [#' . $id . '] a fost modificat de către administratorul ' . $_SESSION["username"] . ' ' . $_SESSION["prenume"] . ' [#' . $_SESSION['id'] . '].');

    $stmt->close();

    $conn->close();
    header("Location: users.php");
    exit();
}
if (isset($_POST['job_info_submit'])) {
    $updatedCompany = $_POST['company'];
    $updatedRole = $_POST['occupation'];
    $updatedCUI = $_POST['position'];

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $conn->set_charset("utf8mb4");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "UPDATE date_utilizatori
              SET Companie = ?, `Rol Companie` = ?, CUI = ?
              WHERE ID_utilizator = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $updatedCompany, $updatedRole, $updatedCUI, $id);
    logMessage('Profilul (Job) utilizatorului ' . $name . ' ' . $prenume . ' [#' . $id . '] a fost modificat de către administratorul ' . $_SESSION["username"] . ' ' . $_SESSION["prenume"] . '.');

    $stmt->execute();

    $stmt->close();

    $conn->close();
    header("Location: users.php");
    exit();
}
if (isset($_POST['account_info_submit'])) {
    $updatedRole = $_POST['role_account'];
    $updatedStatus = $_POST['status'];
    $updatedAccountType = $_POST['type_account'];

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $conn->set_charset("utf8mb4");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "UPDATE utilizatori
              SET Rol = ?, TipCont = ?, Status = ?
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $updatedRole, $updatedAccountType, $updatedStatus, $id);

    $stmt->execute();
    logMessage('Profilul (Date Cont) utilizatorului ' . $name . ' ' . $prenume . ' [#' . $id . '] a fost modificat de către administratorul ' . $_SESSION["username"] . ' ' . $_SESSION["prenume"] . ' [#' . $_SESSION['id'] . '].');

    $stmt->close();

    $conn->close();
    header("Location: users.php");
    exit();
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
                        <div class="d-flex align-items-center user-member__title mb-30 mt-30">
                            <h4 class="text-capitalize">Vizualizezi profilul:
                                <?php echo $name; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="user-info-tab w-100 bg-white global-shadow radius-xl mb-50">
                            <div class="ap-tab-wrapper border-bottom ">
                                <ul class="nav px-30 ap-tab-main text-capitalize" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                            href="#v-pills-home" role="tab" aria-selected="true">
                                            <img src="img/svg/user.svg" alt="user" class="svg">Informații personale</a>
                                    </li>
                                    <?php if ($tipCont == 'Juridică') { ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                                href="#v-pills-profile" role="tab" aria-selected="false">
                                                <img src="img/svg/briefcase.svg" alt="briefcase" class="svg">Informații
                                                job</a>
                                        </li>
                                    <?php } ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                            href="#v-pills-account" role="tab" aria-selected="false">
                                            <img src="img/svg/briefcase.svg" alt="briefcase" class="svg">Informații
                                            cont</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">
                                    <div class="row justify-content-center">
                                        <div class="col-xxl-4 col-10">
                                            <div class="mt-sm-40 mb-sm-50 mt-20 mb-20">
                                                <div class="user-tab-info-title mb-sm-40 mb-20 text-capitalize">
                                                    <h5 class="fw-500">Informații personale</h5>
                                                </div>
                                                <div class="account-profile d-flex align-items-center mb-4">
                                                    <div class="ap-img pro_img_wrapper">
                                                        <input id="file-upload" type="file" name="fileUpload"
                                                            class="d-none">
                                                        <label for="file-upload">
                                                            <img class="ap-img__main rounded-circle wh-120 bg-lighter d-flex"
                                                                src="../images/profile/<?php echo $poza; ?>"
                                                                alt="profile">
                                                            <span class="cross" id="remove_pro_pic">
                                                                <img src="img/svg/camera.svg" alt="camera" class="svg">
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="account-profile__title">
                                                        <h6 class="fs-15 ms-20 fw-500 text-capitalize">Poză de profil
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="edit-profile__body">
                                                    <form method="POST">
                                                        <div class="form-group mb-25">
                                                            <label for="name1">Nume</label>
                                                            <input type="text" class="form-control" id="name1"
                                                                name="name1" value="<?php echo $name; ?>" required>
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="prenume1">Prenume</label>
                                                            <input type="text" class="form-control" id="prenume1"
                                                                name="prenume1" value="<?php echo $prenume; ?>"
                                                                required>
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="email1">Email</label>
                                                            <input type="email" class="form-control" id="email1"
                                                                name="email1" value="<?php echo $email; ?>" required>
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="phone">Număr de telefon</label>
                                                            <input type="tel" class="form-control" id="phone"
                                                                name="phone" value="<?php echo $phone; ?>">
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="dob">Data Nașterii</label>
                                                            <input type="date" class="form-control" id="dob" name="dob"
                                                                value="<?php echo $birthdate; ?>">
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="address">Adresă</label>
                                                            <textarea class="form-control" id="address" name="address"
                                                                rows="3"><?php echo $address; ?></textarea>
                                                        </div>

                                                        <div class="form-group mt-30">
                                                            <button type="submit" name="personal_info_submit"
                                                                class="btn btn-primary btn-xl">Actualizează
                                                                informațiile</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($tipCont == 'Juridică') { ?>

                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                        aria-labelledby="v-pills-profile-tab">
                                        <div class="row justify-content-center">
                                            <div class="col-xxl-4 col-10">
                                                <div class="mt-sm-40 mb-sm-50 mt-20 mb-20">
                                                    <div class="user-tab-info-title mb-sm-40 mb-20 text-capitalize">
                                                        <h5 class="fw-500">Informații job</h5>
                                                    </div>
                                                    <div class="edit-profile__body">
                                                        <form method="POST">
                                                            <div class="form-group mb-25">
                                                                <label for="company">Companie</label>
                                                                <input type="text" class="form-control" id="company"
                                                                    name="company" value="<?php echo $company; ?>" required>
                                                            </div>
                                                            <div class="form-group mb-25">
                                                                <label for="occupation">Rol în companie</label>
                                                                <input type="text" class="form-control" id="occupation"
                                                                    name="occupation" value="<?php echo $role; ?>" required>
                                                            </div>
                                                            <div class="form-group mb-25">
                                                                <label for="position">CUI</label>
                                                                <input type="text" class="form-control" id="position"
                                                                    name="position" value="<?php echo $CUI; ?>">
                                                            </div>
                                                            <div class="form-group mt-30">
                                                                <button type="submit" name="job_info_submit"
                                                                    class="btn btn-primary btn-xl">Actualizează
                                                                    Informațiile</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="tab-pane fade" id="v-pills-account" role="tabpanel"
                                    aria-labelledby="v-pills-profile-tab">
                                    <div class="row justify-content-center">
                                        <div class="col-xxl-4 col-10">
                                            <div class="mt-sm-40 mb-sm-50 mt-20 mb-20">
                                                <div class="user-tab-info-title mb-sm-40 mb-20 text-capitalize">
                                                    <h5 class="fw-500">Informații cont</h5>
                                                </div>
                                                <div class="edit-profile__body">
                                                    <form method="POST">
                                                        <div class="form-group mb-25">
                                                            <label for="role_account">Rol</label>
                                                            <select class="form-control" id="role_account"
                                                                name="role_account" required>
                                                                <option value="Administrator" <?php if ($role2 == 'Administrator')
                                                                    echo 'selected'; ?>>Administrator</option>
                                                                <option value="Utilizator" <?php if ($role2 == 'Utilizator')
                                                                    echo 'selected'; ?>>
                                                                    Utilizator</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="type_account">Tip persoană</label>
                                                            <select class="form-control" id="type_account"
                                                                name="type_account" required>
                                                                <option value="Fizică" <?php if ($tipCont == 'Fizică')
                                                                    echo 'selected'; ?>>Fizică</option>
                                                                <option value="Juridică" <?php if ($tipCont == 'Juridică')
                                                                    echo 'selected'; ?>>
                                                                    Juridică</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-25">
                                                            <label for="status">Status</label>
                                                            <select class="form-control" id="status" name="status"
                                                                required>
                                                                <option value="Activ" <?php if ($status == 'Activ')
                                                                    echo 'selected'; ?>>Activ</option>
                                                                <option value="Dezactivat" <?php if ($status == 'Dezactivat')
                                                                    echo 'selected'; ?>>
                                                                    Dezactivat</option>
                                                                <option value="Blocat" <?php if ($status == 'Blocat')
                                                                    echo 'selected'; ?>>Blocat</option>
                                                                <option value="Neverificat" <?php if ($status == 'Neverificat')
                                                                    echo 'selected'; ?>>
                                                                    Neverificat</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group mt-30">
                                                            <button type="submit" name="account_info_submit"
                                                                class="btn btn-primary btn-xl">Actualizează
                                                                informațiile</button>
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