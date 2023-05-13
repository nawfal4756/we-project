<?php 
    require "../../common/connection.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
        }
        else {
            $keyword = "";
        }
        if (isset($_GET['minSalary'])) {
            $minSalary = $_GET['minSalary'];
        }
        else {
            $minSalary = 0;
        }
        if (isset($_GET['maxSalary'])) {
            $maxSalary = $_GET['maxSalary'];
        }
        else {
            $maxSalary = 10000000000000000000000000000000000;
        }
        if (isset($_GET['location'])) {
            $location = $_GET['location'];
        }
        else {
            $location = "";
        }
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
        }
        else {
            $type = "";
        }
        if (isset($_GET['skills'])) {
            $skills = $_GET['skills'];
        }
        else {
            $skills = [];
        }

        $cleanedKeyword = mysqli_real_escape_string($conn, $keyword);
        $cleanedMinSalary = mysqli_real_escape_string($conn, $minSalary);
        $cleanedMaxSalary = mysqli_real_escape_string($conn, $maxSalary);
        $cleanedLocation = mysqli_real_escape_string($conn, $location);
        $cleanedType = mysqli_real_escape_string($conn, $type);


        try {
            if ($skills != []) {
                $skillsId = "";
                foreach($skills as $skill) {
                    $skillsId .= $skill . ",";
                }
                $cleanedSkillsId = mysqli_real_escape_string($conn, $skillsId);
                $sql = "SELECT jobId FROM jobskills WHERE skillId IN ($cleanedSkillsId);";
                $result = $conn->query($sql);
                $jobIds = "";
                while ($row = $result->fetch_assoc()) {
                    $jobIds .= $row['jobId'];
                }
                $sql = "SELECT * FROM job j, company c WHERE j.title LIKE '%$cleanedKeyword%' AND c.name LIKE '%$cleanedKeyword%' AND j.minSalary BETWEEN $cleanedMinSalary AND $cleanedMaxSalary AND j.maxSalary BETWEEN $cleanedMinSalary AND $cleanedMaxSalary AND j.location LIKE '%$cleanedLocation%' AND j.type LIKE '%$cleanedType%' AND j.id IN ($jobIds);";
            }
            else {
                $sql = "SELECT * FROM job j, company c WHERE j.title LIKE '%$cleanedKeyword%' AND c.name LIKE '%$cleanedKeyword%' AND j.minSalary BETWEEN $cleanedMinSalary AND $cleanedMaxSalary AND j.maxSalary BETWEEN $cleanedMinSalary AND $cleanedMaxSalary AND j.location LIKE '%$cleanedLocation%' AND j.type LIKE '%$cleanedType%';";
            }
            $result = $conn->query($sql);
            $jobs = [];
            while ($row = $result->fetch_assoc()) {
                $jobs[] = $row;
            }
            echo json_encode(array("statusCode" => 200, "data" => $jobs));
            die();
        }
        catch (Exception $e) {
            echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: " . $e->getMessage() . ""));
            die();
        }
    }
    else {
        echo json_encode(array("statusCode" => 405, "data" => "Method Not Allowed"));
        die();
    }
    
?>