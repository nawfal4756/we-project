<?php 
    require "../../common/connection.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $cleanedId = mysqli_real_escape_string($conn, $id);
            $sql = "SELECT j.id, c.id as companyId, c.name, c.logo, j.title, j.requirements, j.location, j.type, j.minSalary, j.maxSalary FROM job j, company c WHERE j.id = '$cleanedId' AND j.companyId = c.id;";
            $skillSql = "SELECT s.name FROM job j, jobskills js, skills s WHERE j.id = '$cleanedId' AND j.id = js.jobId AND js.skillId = s.id;";
            try {
                $result = $conn->query($sql);
                $skillResult = $conn->query($skillSql);
                $skills = array();
                while ($row = $skillResult->fetch_assoc()) {
                    array_push($skills, $row['name']);
                }
                $row = $result->fetch_assoc();
                $row['skills'] = $skills;
                echo json_encode(array("statusCode" => 200, "data" => $row));
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