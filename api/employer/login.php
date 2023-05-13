<?php
    session_start();
    require "../../common/connection.php";
    // header("Content-Type: application/json");

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
    
            $sql = "SELECT id FROM employer WHERE email = '$cleanedEmail' AND password = '$cleanedPassword'";
            
            try {
                $result = $conn->query($sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    
                    // employer session logged in -> sessions
                    $_SESSION['employerId'] = $row['id'];
                    $_SESSION['start'] = time();
                    $_SESSION['type'] = "employer";

                    if ($rememberMe) {
                        $_SESSION['end'] = $_SESSION['start'] + (86400 * 30);
                    }
                    else {
                        $_SESSION['end'] = $_SESSION['start'] + (86400);
                    }
                    // we are logged in 
                    

                    echo '<script>window.location.href="../employer/dashboard.php";</script>';
                    // echo json_encode(array("statusCode" => 200, "data" => "Login Successful"));
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