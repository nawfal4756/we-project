<?php 
    require "../../common/connection.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['gender']) && isset($_POST['password']) && isset($_POST['terms'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $gender = $_POST['gender'];
            $password = $_POST['password'];
            $cleanedName = mysqli_real_escape_string($conn, $name);
            $cleanedEmail = mysqli_real_escape_string($conn, $email);
            $cleanedPhone = mysqli_real_escape_string($conn, $phone);
            $cleanedGender = mysqli_real_escape_string($conn, $gender);
            $cleanedPassword = mysqli_real_escape_string($conn, $password);

            if ($gender != 'Male' || $gender != 'Female') {
                echo json_encode(array("statusCode" => 400, "data" => "Gender Valued Incorrect"));
                die();
            }

            $sql = "INSERT INTO users(name, email, phone, gender, password) VALUES ('$cleanedName', '$cleanedEmail', '$cleanedPhone', '$cleanedGender', '$cleanedPassword')";
            try {
                $result = $conn->query($sql);
                echo json_encode(array("statusCode" => 200, "data" => "Sign Up Successful"));
            }
            catch (Exception $e) {
                echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: " . $e->getMessage() . ""));
            }
        }
        else {
            echo json_encode(array("statusCode" => 400, "data" => "Bad Request"));
        }
    }
    else {
        echo json_encode(array("statusCode" => 405, "data" => "Method Not Allowed"));
    }
?>