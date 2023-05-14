<?php 
    require "../users/verification.php";
    require "../../common/connection.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['jobId']) && isset($_POST['companyId'])) {
            $jobId = $_POST['jobId'];
            $companyId = $_POST['companyId'];
            $userId = $_SESSION['id'];

            $cleanedJobId = mysqli_real_escape_string($conn, $jobId);
            $cleanedCompanyId = mysqli_real_escape_string($conn, $companyId);

            $sql = "INSERT INTO jobapplication (userId, companyId, jobId) VALUES ('$userId', '$cleanedCompanyId', '$cleanedJobId');";
            try {
                $result = $conn->query($sql);
                echo json_encode(array("statusCode" => 200, "data" => "Applied successfully"));
                die();
            }
            catch (Exception $e) {
                echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: " . $e->getMessage() . "", "sql" => $sql));
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