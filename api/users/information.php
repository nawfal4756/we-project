<?php 
    require "verification.php";
    require "../../common/connection.php";
    require "../../common/filecheck.php";

    $user_id = $_SESSION['id'];
    header("Content-Type: application/json;");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['part'])) {
            $part = $_POST['part'];
            if ($part == '1') {
                if (isset($_POST['specialization']) && isset($_POST['dob'])) {
                    $specialization = $_POST['specialization'];
                    $dob = $_POST['dob'];
                    
                    try {
                        $dateConverted = date('Y-m-d', strtotime(str_replace('-', '/', $dob)));
                        $cleanedSpecialization = mysqli_real_escape_string($conn, $specialization);
                        $sql = "UPDATE user SET specialization = '$cleanedSpecialization', dob = '$dateConverted' WHERE id = '$user_id'";
                        $result = $conn->query($sql);
                        echo json_encode(array("statusCode" => 200, "data" => "Information Updated Successfully"));
                        die();
                    }
                    catch (Exception $e) {
                        echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: ". $e->getMessage().""));
                        die();
                    }
                }
                else {
                    echo json_encode(array("statusCode" => 400, "data" => "Bad Request"));
                    die();
                }
            }
            else if ($part == '2') {
                if (isset($_FILES['profile']) && isset($_FILES['cv'])) {
                    $profileName = $_FILES['profile']['name'];
                    $profileTmpName = $_FILES['profile']['tmp_name'];
                    $profileSize = $_FILES['profile']['size'];

                    $cvName = $_FILES['cv']['name'];
                    $cvTmpName = $_FILES['cv']['tmp_name'];
                    $cvSize = $_FILES['cv']['size'];

                    $profileAns = uploadFileCheck($profileName, $profileTmpName, $profileSize, 3000000, array('jpg', 'jpeg', 'png'));
                    $cvAns = uploadFileCheck($cvName, $cvTmpName, $cvSize, 5000000, array('pdf', 'docx', 'doc'));

                    if ($profileAns == '1' || $cvAns == '1') {
                        echo json_encode(array("statusCode" => 415, "data" => "File Type Not Allowed"));
                        die();
                    }
                    else if ($profileAns == '2' || $cvAns == '2') {
                        echo json_encode(array("statusCode" => 413, "data" => "File Size Too Large"));
                        die();
                    }
                    else {
                        try {
                            $fileExt = explode('.', $profileName);
                            $fileActualExt = strtolower(end($fileExt));
                            $fileNameNew = uniqid('', true).".".$fileActualExt;
                            $fileDestination = '../../uploads/'.$fileNameNew;
                            move_uploaded_file($profileTmpName, $fileDestination);
                            
                            $fileExt = explode('.', $cvName);
                            $fileActualExt = strtolower(end($fileExt));
                            $fileNameNew = uniqid('', true).".".$fileActualExt;
                            $fileDestination = '../../uploads/'.$fileNameNew;

                            move_uploaded_file($cvTmpName, $fileDestination);
                            $sql = "UPDATE user SET profilePic = '$profileName', cv = '$cvName' WHERE id = '$user_id'";
                            $result = $conn->query($sql);
                            echo json_encode(array("statusCode" => 200, "data" => "Information Updated Successfully"));
                            die();
                        }
                        catch (Exception $e) {
                            echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: ". $e->getMessage().""));
                            die();
                        }
                    }
                }
                else {
                    echo json_encode(array("statusCode" => 400, "data" => "Bad Request"));
                    die();
                }
            }
            else if ($part == '3') {
                if (isset($_POST['degree']) && isset($_POST['field']) && isset($_POST['instituteName']) && isset($_POST['cgpa']) && isset($_POST['ending'])) {
                    $degree = $_POST['degree'];
                    $field = $_POST['field'];
                    $instituteName = $_POST['instituteName'];
                    $cgpa = $_POST['cgpa'];
                    $ending = $_POST['ending'];

                    $degreeCount = count($degree);
                    $fieldCount = count($field);
                    $instituteNameCount = count($instituteName);
                    $cgpaCount = count($cgpa);
                    $endingCount = count($ending);

                    if ($degreeCount != $fieldCount || $degreeCount != $instituteNameCount || $degreeCount != $cgpaCount || $degreeCount != $fieldCount) {
                        echo json_encode(array("statusCode" => 400, "data" => "Bad Request"));
                        die();
                    }

                    try {
                        $conn->begin_transaction();
                        $sql = "DELETE FROM usereducation WHERE userId = '$user_id'";
                        $conn->query($sql);
                        for ($count = 0; $count < $degreeCount; $count++) {
                            $cleanedDegree = mysqli_real_escape_string($conn, $degree[$count]);
                            $cleanedField = mysqli_real_escape_string($conn, $field[$count]);
                            $cleanedInstituteName = mysqli_real_escape_string($conn, $instituteName[$count]);
                            $cleanedCgpa = mysqli_real_escape_string($conn, $cgpa[$count]);
                            $cleanedEnding = mysqli_real_escape_string($conn, $ending[$count]);

                            $sql = "INSERT INTO usereducation (userId, degreeId, field, instituteName, cgpa, endYear) VALUES ('$user_id', '$cleanedDegree', '$cleanedField', '$cleanedInstituteName', '$cleanedCgpa', '$cleanedEnding')";
                            $result = $conn->query($sql);
                        }
                        $conn->commit();
                        echo json_encode(array("statusCode" => 200, "data" => "Information Updated Successfully"));
                        die();
                    }
                    catch (Exception $e) {
                        $conn->rollback();
                        echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: ". $e->getMessage().""));
                        die();
                    }
                }
                else {
                    echo json_encode(array("statusCode" => 400, "data" => "Bad Request"));
                    die();
                }
            }
            else if ($part == '4') {
                if (isset($_POST['skills'])) {
                    $skills = $_POST['skills'];
                    $skillsCount = count($skills);

                    try {
                        $conn->begin_transaction();
                        $sql = "DELETE FROM userskills WHERE userId = '$user_id'";
                        $conn->query($sql);
                        for ($count = 0; $count < $skillsCount; $count++) {
                            $cleanedSkill = mysqli_real_escape_string($conn, $skills[$count]);
                            $sql = "INSERT INTO userskills (userId, skillId) VALUES ('$user_id', '$cleanedSkill')";
                            $result = $conn->query($sql);
                        }
                        $sql = "UPDATE user SET completeProfile = 1 WHERE id = '$user_id'";
                        $conn->query($sql);
                        $conn->commit();
                        echo json_encode(array("statusCode" => 200, "data" => "Information Updated Successfully"));
                        die();
                    }
                    catch (Exception $e) {
                        $conn->rollback();
                        echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: ". $e->getMessage().""));
                        die();
                    }
                }
                else {
                    echo json_encode(array("statusCode" => 400, "data" => "Bad Request"));
                    die();
                }
            }
            else {
                echo json_encode(array("statusCode" => 400, "data" => "Bad Request"));
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