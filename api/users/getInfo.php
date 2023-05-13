<?php 
    require "verification.php";
    require "../../common/connection.php";
    header("Content-Type: application/json;");

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $id = $_SESSION['id'];
        $sql = "SELECT name, email, phone, dob, specialization, profilePic, cv FROM user WHERE id = $id";
        $skillSql = "SELECT skillId FROM userskills WHERE userId = $id";
        try {
            $result = $conn->query($sql);
            $skillResult = $conn->query($skillSql);
            $skillData = array();
            while ($skillRow = $skillResult->fetch_assoc()) {
                array_push($skillData, $skillRow['skillId']);
            }
            $row = $result->fetch_assoc();
            $data = array(
                "name" => $row['name'],
                "email" => $row['email'],
                "phone" => $row['phone'],
                "dob" => $row['dob'],
                "specialization" => $row['specialization'],
                "profilePic" => $row['profilePic'],
                "cv" => $row['cv'],
                "skills" => $skillData
            );
            echo json_encode(array("statusCode" => 200, "data" => $data));
        }
        catch (Exception $e) {
            echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: ". $e->getMessage().""));
            die();
        }
    }
    else {
        echo json_encode(array("statusCode" => 405, "data" => "Method Not Allowed"));
        die();
    }
?>