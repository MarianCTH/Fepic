<?php
$log_file = "../error.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

session_start();

$response = array();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    require_once '../../config/config.php';

    $user_id = $_SESSION["id"];
    $event_id = $_GET["event_id"];

    $check_stmt = $db->prepare("SELECT * FROM events_signups WHERE USER_ID = ? AND EVENT_ID = ?");
    
    if ($check_stmt) {
        $check_stmt->bind_param("ii", $user_id, $event_id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $response['success'] = false;
            $response['message'] = "Sunteți deja înregistrat în acest eveniment.";
        } else {
            $uploadDir = '../../admin/documents/';
            $uploadedFileName = $_FILES['file']['name'];
            $uploadedFile = $uploadDir . $uploadedFileName;

            $counter = 1;
            while (file_exists($uploadedFile)) {
                $uploadedFileName = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME) . "_$counter." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $uploadedFile = $uploadDir . $uploadedFileName;
                $counter++;
            }

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFile)) {
                $insert_stmt = $db->prepare("INSERT INTO events_signups (USER_ID, EVENT_ID, UPLOADED_DOCUMENT) VALUES (?, ?, ?)");
                if ($insert_stmt) {
                    $insert_stmt->bind_param("iis", $user_id, $event_id, $uploadedFileName);
                    
                    if ($insert_stmt->execute()) {
                        $response['success'] = true;
                        $response['message'] = "Felicitări v-ați înscris cu succes la acest eveniment!";
                    } else {
                        $response['message'] = "Error registering for the event: " . $insert_stmt->error;
                    }

                    $insert_stmt->close();
                } else {
                    $response['message'] = "Error preparing the registration statement.";
                }
            } else {
                $response['message'] = "File upload failed.";
            }

            $check_stmt->close();
        }
    } else {
        $response['message'] = "Error preparing the check statement.";
    }

    $db->close();
} else {
    $response['message'] = "User not logged in";
}

header('Content-Type: application/json');
echo json_encode($response);
?>
