<?php 
    require "../users/verification.php";
    // require "../../common/connection.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $userId = $_SESSION['id'];
        $sql = "SELECT c.name, j.title, j.type, ja.status FROM company c, job j, jobapplication ja, user u WHERE c.id = j.companyId AND j.id = ja.jobId AND ja.userId = u.id AND ja.userId = $userId AND u.blocked = 0;";
        try {
            $result = $conn->query($sql);
            $data = array();
            while ($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
            echo json_encode(array("statusCode" => 200, "data" => $data, "num"=>mysqli_num_rows($result)));
        } catch (Exception $e) {
            echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: ". $e->getMessage().""));
            die();
        }
    }
    else {
        echo json_encode(array("statusCode" => 405, "data" => "Method Not Allowed"));
        die();
    }
?>