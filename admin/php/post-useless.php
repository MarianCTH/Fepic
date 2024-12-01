<?php
session_start();
if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) {
    header("Location: ../error.php");
    exit();
}
require_once '../../config/config.php';
$targetDir = "../../images/blog/"; // Specify the target directory where the uploaded file should be moved
$error = "";

// Prepare the SQL statement
$stmt = $db->prepare("INSERT INTO blog (ID_autor, Subiect, Text, Image, ImageIndex, Categorie, Comentarii, Tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssss", $ID_autor, $Subiect, $Text, $Image, $ImageIndex, $Categorie, $Comentarii, $Tags);

// Set the values from the form
$ID_autor = $_SESSION['id'];
$Subiect = $_POST["subject"];
$Text = $_POST["content"];

if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0) {
    $Image = $_FILES["image"]["name"];
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // File uploaded successfully
        error_log('Image uploaded: ' . $Image);
    } else {
        // Error moving the uploaded file
        error_log('Error moving the uploaded file');
    }
} else {
    $Image = ""; // Set default value if no image is uploaded
    error_log('No image uploaded');
}
$ImageIndex = "image_index"; // Example: Set the index of the image
$Categorie = $_POST["category"];
$Comentarii = isset($_POST['comentarii']) ? 1 : 0;
$Tags = $_POST["tags"];

$stmt->execute();

// Check if the query was successful
if ($stmt->affected_rows > 0) {

} else {
    $error = "Error inserting data.";
}

// Close the statement and connection
$stmt->close();
$db->close();
?>