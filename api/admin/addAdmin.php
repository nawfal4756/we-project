<?php 
    require "verification.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            $cleanedName = mysqli_real_escape_string($conn, $name);
            $cleanedEmail = mysqli_real_escape_string($conn, $email);
            $cleanedPhone = mysqli_real_escape_string($conn, $phone);
            $cleanedPassword = mysqli_real_escape_string($conn, $password);

            $sql = "INSERT INTO `admin` (`name`, `email`, `phone`, `password`) VALUES ('$cleanedName', '$cleanedEmail', '$cleanedPhone', '$cleanedPassword')";

            try {
                $result = mysqli_query($conn, $sql);
                echo json_encode(array("statusCode" => 200, "data" => "Admin Added Successful"));
                die();
            }
            catch (Exception $e) {
                echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: " . $e->getMessage() . ""));
                die();
            }
        }
        else {
            echo json_encode(array("statusCode" => 400, "data" => "Bad Request"));
            die();
        }
    }
    else {
        echo json_encode(array("statusCode" => 405, "data" => "Method Not Allowed"));
        die();
    }
?>