<?php
    require "../../common/connection.php";
    header("Content-Type: application/json");

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

        $id = $_SESSION['id'];
        $sql = "SELECT blocked FROM user WHERE id = $id;";
        try {
            $result = $conn->query($sql);
            if (mysqli_num_rows($result) == 0) {
                echo json_encode(array("statusCode" => 400, "data" => "Bad Request"));
                die();
            }
            $row = $result->fetch_assoc();
            if ($row['blocked'] == 1) {
                echo json_encode(array("statusCode" => 403, "data" => "Forbidden"));
                die();
            }
        }
        catch (Exception $e) {
            echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: ". $e->getMessage().""));
            die();
        }
    }
    else {
        echo json_encode(array("statusCode" => 401, "data" => "Unauthorized"));
        die();
    }
?>