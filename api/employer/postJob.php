<?php 
    require "../../common/connection.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if (isset($_POST['job-title']) && isset($_POST['job-loc']) && isset($_POST['jobType']) && isset($_POST['job-req']) 
        && isset($_POST['min-sal']) && isset($_POST['max-sal'])) 
        {
            $jobTitle = (isset($_POST['job-title'])) ? mysqli_real_escape_string($conn, trim($_POST['job-title'])) : '';
            $jobLocation = (isset($_POST['job-loc'])) ? mysqli_real_escape_string($conn, trim($_POST['job-loc'])) : '';
            $jobType = (isset($_POST['jobType'])) ? mysqli_real_escape_string($conn, trim($_POST['jobType'])) : '';
            $jobRequirements = (isset($_POST['job-req'])) ? mysqli_real_escape_string($conn, trim($_POST['job-req'])) : '';
            $minSalary = (isset($_POST['min-sal'])) ? mysqli_real_escape_string($conn, trim($_POST['min-sal'])) : '';
            $maxSalary = (isset($_POST['max-sal'])) ? mysqli_real_escape_string($conn, trim($_POST['max-sal'])) : '';
            $employerId = $_SESSION['employerId'];

            //getting copnay id as a result from empoyer id
            $s ="select companyId from job where employerId='".$employerId."';";
            $res = mysqli_query($conn, $s);
            $row = mysqli_fetch_array($res);
            
            $companyId = $row['companyId'];

            // employer 
            $sql = "INSERT INTO job(companyId, employerId, title, location, type, requirements, minSalary, maxSalary) VALUES('$companyId','$employerId', '$jobTitle', '$jobLocation', '$jobType', '$jobRequirements', '$minSalary', '$maxSalary')";

            try {
                $result = $conn->query($sql);
                
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