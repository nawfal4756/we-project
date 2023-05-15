<?php 
    require "../../common/connection.php";

    // header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['gender']) 
        && isset($_POST['password']) && isset($_POST['companyName']) && $_POST['companyLocation']) 
        {
            // employer cleaned 
            // $idCleaned = (isset($_POST['id'])) ? mysqli_real_escape_string($conn, trim($_POST['id'])) : '';
            $nameCleaned = (isset($_POST['name'])) ? mysqli_real_escape_string($conn, trim($_POST['name'])) : '';
            $emailCleaned = (isset($_POST['email'])) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
            $phoneCleaned = (isset($_POST['phone'])) ? mysqli_real_escape_string($conn, trim($_POST['phone'])) : '';
            $passwordCleaned = (isset($_POST['password'])) ? mysqli_real_escape_string($conn, trim($_POST['password'])) : '';
            $genderCleaned = (isset($_POST['gender'])) ? mysqli_real_escape_string($conn, trim($_POST['gender'])) : '';

            
            // compnay cleaned 
            // $cleanedCompanyId = mysqli_real_escape_string($conn, $_POST['companyId']);
            $cleanedCompanyName = mysqli_real_escape_string($conn, $_POST['companyName']);
            $cleanedCompanyLocation = mysqli_real_escape_string($conn, $_POST['companyLocation']);



            if ($_POST['gender'] != 'Male' && $_POST['gender'] != 'Female') {
                echo json_encode(array("statusCode" => 400, "data" => "Gender Value Incorrect"));
                die();
            }
            
            
            // compnay  
            $sql = "INSERT INTO company( name, logo, location, blocked)
            VALUES ( '$cleanedCompanyName', '', '$cleanedCompanyLocation', '')";

            
            
            // employer 
            
            try {
                $result = $conn->query($sql);
                $companyID= $conn->insert_id;
                $emp = "INSERT INTO employer(name, email, phone, password, gender,  companyId) VALUES('$nameCleaned', '$emailCleaned', '$phoneCleaned', '$passwordCleaned', '$genderCleaned',  $companyID)";
                $result2 = mysqli_query($conn , $emp);
                
                // also maintaining sessions when signup takes place 
                $_SESSION['employerId'] = $row['id'];
                $_SESSION['companyId'] = $companyID;
                $_SESSION['start'] = time();
                $_SESSION['type'] = "employer";
                // echo json_encode(array("statusCode" => 200, "data" => "Successful"));
                echo '<script>window.location.href="../employer/dashboard.php";</script>';
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