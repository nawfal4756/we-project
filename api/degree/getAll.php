<?php 
    require "../users/verification.php";
    // require "../../common/connection.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $sql = "SELECT * FROM degree";
        try {
            $result = $conn->query($sql);
            $data = array();
            while ($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
            echo json_encode(array("statusCode" => 200, "data" => $data));
        }
        catch (Exception $e) {
            echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: ".$e->getMessage()));
        }
    }
    else {
        echo json_encode(array("statusCode" => 405, "data" => "Method Not Allowed"));
        die();
    }
?>