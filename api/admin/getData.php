<?php 
    require "verification.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            $cleanedType = mysqli_real_escape_string($conn, $type);

            if ($cleanedType == "company") {
                $sql = "SELECT id, name, location, blocked FROM company";
            }
            else if ($cleanedType == "employers") {
                $sql = "SELECT id, name, email, blocked FROM employer;";
            }
            else if ($cleanedType == "job") {
                $sql = "SELECT j.id, j.title, c.name, j.blocked FROM job j, company c WHERE j.companyId = c.id;";
            }
            else if ($cleanedType == "user") {
                $sql = "SELECT id, name, email, blocked FROM user;";
            }
            else if ($cleanedType == "admin") {
                $sql = "SELECT id, name, email, blocked FROM admin;";
            } 
            else {
                echo json_encode(array("statusCode"=>400, "data"=>"Invalid type"));
                exit();
            }

            try {
                $result = mysqli_query($conn, $sql);
                $rows = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($rows, $row);
                }
                echo json_encode(array("statusCode"=>200, "data"=>$rows, "num" => mysqli_num_rows($result)));
                die();
            }
            catch (Exception $e) {
                echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: " . $e->getMessage() . ""));
                die();
            }
        }
        else {
            echo json_encode(array("statusCode"=>400, "data"=>"Bad Request"));
            die();
        }
    }
    else {
        echo json_encode(array("statusCode" => 405, "data" => "Method Not Allowed"));
    }
?>