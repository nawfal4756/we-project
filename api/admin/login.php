<?php
    session_start();
    require "../../common/connection.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $cleanedEmail = mysqli_real_escape_string($conn, $email);
            $cleanedPassword = mysqli_real_escape_string($conn, $password);
            
            if (isset($_POST['rememberMe'])) {
                $rememberMe = true;
            }
            else {
                $rememberMe = false;
            }
    
            $sql = "SELECT id, blocked FROM admin WHERE email = '$cleanedEmail' AND password = '$cleanedPassword'";
            
            try {
                $result = $conn->query($sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if ($row['blocked'] == 1) {
                        echo json_encode(array("statusCode" => 401, "data" => "Account is Blocked"));
                        die();
                    }
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['start'] = time();
                    $_SESSION['type'] = "admin";
                    if ($rememberMe) {
                        $_SESSION['end'] = $_SESSION['start'] + (86400 * 30);
                    }
                    else {
                        $_SESSION['end'] = $_SESSION['start'] + (86400);
                    }
                    echo json_encode(array("statusCode" => 200, "data" => "Login Successful"));
                }
                else {
                    echo json_encode(array("statusCode" => 401, "data" => "Invalid Credentials"));
                }
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