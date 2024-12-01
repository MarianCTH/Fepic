<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();
$response = array("success" => false);

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
    header("location: ../../index");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../../config/config.php';
    include "../../admin/php/logs/log.php";
    $logFile = '../../admin/php/logs/activity.log';

    $userId = $_SESSION['id'];
    $username = $_POST['username'];
    $prenume = $_POST['prenume'];

    $orgName = $role = $cui = $cod_caen = "";
    if (isset($_POST['orgName'])){
        $orgName = $_POST['orgName'];
    }
    if (isset($_POST['rol_org'])){
        $role = $_POST['rol_org'];
    }
    if (isset($_POST['cui'])){
        $cui = $_POST['cui'];
    }
    if (isset($_POST['coduri_caen'])){
        $cod_caen = $_POST['coduri_caen'];
    }

    $poza = $_POST['selectedImageName'];
    $location = $_POST['location'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    if (isset($_POST['birthday']) && $_POST['birthday'] !== "") {
        $birthday = $_POST['birthday'];
    } else {
        $birthday = "00/00/0000";
    }
    

    $stmtCheckEmail = $db->prepare("SELECT ID FROM utilizatori WHERE Email = ?");
    $stmtCheckEmail->bind_param("s", $email);
    $stmtCheckEmail->execute();
    $emailExists = $stmtCheckEmail->fetch();
    $stmtCheckEmail->close();
    
    if ($emailExists && $email != $_SESSION['email']) {
        $response = array('status' => 'error', 'message' => 'Acest email este folosit de un alt utilizator !');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    if(isset($_FILES['fileToUpload'])){
        if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
            $originalFileName = $_FILES['fileToUpload']['name'];
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            
            $newFileName = $originalFileName;
            $counter = 1;
            while (file_exists('../../images/profile/' . $newFileName)) {
                $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $counter . '.' . $fileExtension;
                $counter++;
            }
    
            $tempFilePath = $_FILES['fileToUpload']['tmp_name'];
            $newFilePath = '../../images/profile/' . $newFileName;
    
            if (move_uploaded_file($tempFilePath, $newFilePath)) {
                $poza = $newFileName;
            }
        }    
    }
    else{
        $poza = $_POST['originalPhoto'];
    }

    $stmt = $db->prepare("UPDATE utilizatori SET Nume=?, Prenume=?, Email=?, Poza=? WHERE ID=?");
    $stmt->bind_param("ssssi", $username, $prenume, $email, $poza, $userId);
    $stmtResult = $stmt->execute();
    
    $stmt2 = $db->prepare("UPDATE date_utilizatori SET Adresă=?, Data_nasterii=?, Companie=?, `Rol Companie`=?, Telefon=?, CUI = ?, Coduri_CAEN = ?
   WHERE ID_utilizator=?");
    $stmt2->bind_param("sssssssi", $location, $birthday, $orgName, $role, $phone, $cui, $cod_caen, $userId);
    $stmt2Result = $stmt2->execute();

    if ($stmtResult && $stmt2Result) {
        $response = array('status' => 'success', 'message' => 'Datele dumneavoastră au fost actualizate cu succes !');
        logMessage('Utilizatorul ' . $username . ' ' . $prenume . ' [#' . $userId . '] și-a actualizat profilul.');
    }

    $stmt->close();
    $stmt2->close();
    $db->close();
}

header('Content-Type: application/json');
echo json_encode($response);
