<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
        if ($_SESSION['end'] < time()) {
            session_unset();
            session_destroy();
            echo json_encode(array("statusCode" => 401, "data" => "Session Expired"));
            die();
        }

        if ($_SESSION['type'] != "users") {
            echo json_encode(array("statusCode" => 403, "data" => "Forbidden"));
            die();
        }
    }
    else {
        echo json_encode(array("statusCode" => 401, "data" => "Unauthorized"));
        die();
    }
?>