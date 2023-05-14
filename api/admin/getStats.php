<?php 
    require "verification.php";
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $entities = array("user", "company", "employer", "job");
        $data = array();
        try {
            foreach($entities as $entity) {
                $blocked = 0;
                $sql = "SELECT COUNT(*) AS blocked FROM $entity WHERE blocked = $blocked;";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $unblocked = $row['blocked'];
                $blocked = 1;
                $sql = "SELECT COUNT(*) AS blocked FROM $entity WHERE blocked = $blocked;";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $blocked = $row['blocked'];
                $total = (int)$unblocked + (int)$blocked;
                $data[$entity] = array("total" => $total, "blocked" => (int)$blocked, "unblocked" => (int)$unblocked);
            }
            echo json_encode(array("statusCode" => 200, "data" => $data));
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