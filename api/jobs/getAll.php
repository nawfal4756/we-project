<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
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
                $skillsId = join(",", $skills);
                $cleanedSkillsId = mysqli_real_escape_string($conn, $skillsId);
                if (isset($_SESSION['id'])) {
                    $sql = "SELECT j.id, c.id as companyId, c.name, c.logo, j.title, j.location, j.type, j.minSalary, j.maxSalary FROM job j, company c WHERE (j.title LIKE '%$cleanedKeyword%' OR c.name LIKE '%$cleanedKeyword%') AND j.minSalary BETWEEN $cleanedMinSalary AND $cleanedMaxSalary AND j.maxSalary BETWEEN $cleanedMinSalary AND $cleanedMaxSalary AND j.location LIKE '%$cleanedLocation%' AND j.type LIKE '%$cleanedType%' AND j.id IN (SELECT jobId FROM jobskills WHERE skillId IN ($cleanedSkillsId)) AND j.id NOT IN (SELECT jobId FROM jobapplication WHERE userId = " . $_SESSION['id'] . ") ORDER BY createdAt DESC;";
                }
                else {
                    $sql = "SELECT j.id, c.id as companyId, c.name, c.logo, j.title, j.location, j.type, j.minSalary, j.maxSalary FROM job j, company c WHERE (j.title LIKE '%$cleanedKeyword%' OR c.name LIKE '%$cleanedKeyword%') AND j.minSalary BETWEEN $cleanedMinSalary AND $cleanedMaxSalary AND j.maxSalary BETWEEN $cleanedMinSalary AND $cleanedMaxSalary AND j.location LIKE '%$cleanedLocation%' AND j.type LIKE '%$cleanedType%' AND j.id IN (SELECT jobId FROM jobskills WHERE skillId IN ($cleanedSkillsId)) ORDER BY createdAt DESC;";
                }
            }
            else {
                if (isset($_SESSION['id'])) {
                    $userId = $_SESSION['id'];
                    $sql = "SELECT j.id, c.id as companyId, c.name, c.logo, j.title, j.location, j.type, j.minSalary, j.maxSalary FROM job j, company c WHERE (j.title LIKE '%$cleanedKeyword%' OR c.name LIKE '%$cleanedKeyword%') AND j.minSalary BETWEEN '$cleanedMinSalary' AND '$cleanedMaxSalary' AND j.maxSalary BETWEEN '$cleanedMinSalary' AND '$cleanedMaxSalary' AND j.location LIKE '%$cleanedLocation%' AND j.type LIKE '%$cleanedType%' AND j.id NOT IN (SELECT jobId FROM jobapplication WHERE userId = '$userId') ORDER BY createdAt DESC;";
                }
                else {
                    $sql = "SELECT j.id, c.id as companyId, c.name, c.logo, j.title, j.location, j.type, j.minSalary, j.maxSalary FROM job j, company c WHERE (j.title LIKE '%$cleanedKeyword%' OR c.name LIKE '%$cleanedKeyword%') AND j.minSalary BETWEEN $cleanedMinSalary AND $cleanedMaxSalary AND j.maxSalary BETWEEN $cleanedMinSalary AND $cleanedMaxSalary AND j.location LIKE '%$cleanedLocation%' AND j.type LIKE '%$cleanedType%' ORDER BY createdAt DESC;";
                }
            }
            $result = $conn->query($sql);
            $jobs = [];
            while ($row = $result->fetch_assoc()) {
                $skills = [];
                $sqlSkill = "SELECT s.name FROM skills s, jobskills js WHERE js.jobId = " . $row['id'] . " AND js.skillId = s.id;";
                $result2 = $conn->query($sqlSkill);
                while ($row2 = $result2->fetch_assoc()) {
                    array_push($skills, $row2['name']);
                }
                array_push($jobs, array(
                    "id" => $row['id'],
                    "companyId" => $row['companyId'],
                    "companyName" => $row['name'], 
                    "logo" => $row['logo'],
                    "title" => $row['title'],
                    "location" => $row['location'],
                    "type" => $row['type'],
                    "minSalary" => $row['minSalary'],
                    "maxSalary" => $row['maxSalary'],
                    "skills" => $skills
                ));
            }
            echo json_encode(array("statusCode" => 200, "data" => $jobs, "num" => mysqli_num_rows($result)));
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