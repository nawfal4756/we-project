<?php
    require "verification.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['type']) && isset($_POST['id']) && isset($_POST['blocked'])) {
            $type = $_POST['type'];
            $id = $_POST['id'];
            $blocked = $_POST['blocked'];

            $cleanedType = mysqli_real_escape_string($conn, $type);
            $cleanedId = mysqli_real_escape_string($conn, $id);
            $cleanedBlocked = mysqli_real_escape_string($conn, $blocked);

            $nowBlocked = 0;
            if ($cleanedBlocked == "1") {
                $nowBlocked = 0;
            }
            else if ($cleanedBlocked == "0") {
                $nowBlocked = 1;
            }
            else {
                echo json_encode(array("statusCode"=>400, "data"=>"Invalid blocked value"));
                exit();
            }

            if ($cleanedType == "company") {
                $sql = "UPDATE company SET blocked = '$nowBlocked' WHERE id = '$cleanedId';";
            }
            else if ($cleanedType == "employers") {
                $sql = "UPDATE employer SET blocked = '$nowBlocked' WHERE id = '$cleanedId';";
            }
            else if ($cleanedType == "job") {
                $sql = "UPDATE job SET blocked = '$nowBlocked' WHERE id = '$cleanedId';";
            }
            else if ($cleanedType == "user") {
                $sql = "UPDATE user SET blocked = '$nowBlocked' WHERE id = '$cleanedId';";
            } 
            else if ($cleanedType == "admin") {
                $sql = "UPDATE admin SET blocked = '$nowBlocked' WHERE id = '$cleanedId';";
            } 
            else {
                echo json_encode(array("statusCode"=>400, "data"=>"Invalid type"));
                exit();
            }

            try {
                $result = $conn->query($sql);
                echo json_encode(array("statusCode"=>200, "data"=>"Success"));
                die();
            }
            catch (Exception $e) {
                echo json_encode(array("statusCode"=>500, "data"=>"Internal Server Error: " . $e->getMessage() . ""));
                die();
            }
        }
        else {
            echo json_encode(array("statusCode"=>400, "data"=>"Bad Request"));
            die();
        }
    }
    else {
        echo json_encode(array("statusCode"=>405, "data"=>"Method Not Allowed"));
        die();
    }
?>