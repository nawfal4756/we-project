<?php 
    require "verification.php";
    // require "../../common/connection.php";
    require "../../common/filecheck.php";
    header("Content-Type: application/json;");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['part'])) {
            $part = $_POST['part'];
            $id = $_SESSION['id'];

            if ($part == "1") {
                if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["dob"]) && isset($_POST["specialization"]) && isset($_POST["skills"])) {
                    $name = $_POST["name"];
                    $email = $_POST["email"];
                    $phone = $_POST["phone"];
                    $dob = $_POST["dob"];
                    $specialization = $_POST["specialization"];
                    $skills = $_POST["skills"];

                    $cleanedName = mysqli_real_escape_string($conn, $name);
                    $cleanedEmail = mysqli_real_escape_string($conn, $email);
                    $cleanedPhone = mysqli_real_escape_string($conn, $phone);
                    $cleanedDob = mysqli_real_escape_string($conn, $dob);
                    $cleanedSpecialization = mysqli_real_escape_string($conn, $specialization);
                    
                    $skillsCount = count($skills);
                    try {
                        $conn->begin_transaction();
                        $sql = "DELETE FROM userskills WHERE userId = $id";
                        $result = mysqli_query($conn, $sql);
                        for ($count = 0; $count < $skillsCount; $count++) {
                            $cleanedSkill = mysqli_real_escape_string($conn, $skills[$count]);
                            $sql = "INSERT INTO userskills (userId, skillId) VALUES ('$id', '$cleanedSkill')";
                            $result = $conn->query($sql);
                        }
                        $sql = "UPDATE user SET name = '$cleanedName', email = '$cleanedEmail', phone = '$cleanedPhone', dob = '$cleanedDob', specialization = '$cleanedSpecialization' WHERE id = $id";
                        $result = mysqli_query($conn, $sql);
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
            else if ($part == '2') {
                if ($_FILES['profile']['name'] != "" || $_FILES['cv']['name'] != "") {
                    $sql = "SELECT profilePic, cv FROM user WHERE id = '$id'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $profilePic = $row['profilePic'];
                    $cv = $row['cv'];

                    if ($_FILES['profile']['name'] != "") {
                        $profileName = $_FILES['profile']['name'];
                        $profileTmpName = $_FILES['profile']['tmp_name'];
                        $profileSize = $_FILES['profile']['size'];
    
                        $profileAns = uploadFileCheck($profileName, $profileTmpName, $profileSize, 3000000, array('jpg', 'jpeg', 'png'));
                        
                        if ($profileAns == '1') {
                            echo json_encode(array("statusCode" => 415, "data" => "File Type Not Allowed"));
                            die();
                        }
                        else if ($profileAns == '2') {
                            echo json_encode(array("statusCode" => 413, "data" => "File Size Too Large"));
                            die();
                        }
                        else {
                            try {
                                $fileExt = explode('.', $profileName);
                                $fileActualExt = strtolower(end($fileExt));
                                $profileNameNew = uniqid('', true).".".$fileActualExt;
                                $fileDestination = '../../uploads/'.$profileNameNew;
                                move_uploaded_file($profileTmpName, $fileDestination);
                                unlink('../../uploads/'.$profilePic);
    
                                $sql = "UPDATE user SET profilePic = '$profileNameNew' WHERE id = '$id'";
                                $result = $conn->query($sql);
                                echo json_encode(array("statusCode" => 200, "data" => "Information Updated Successfully"));
                            }
                            catch (Exception $e) {
                                echo json_encode(array("statusCode" => 500, "data" => "Internal Server Error: ". $e->getMessage().""));
                                die();
                            }
                        }
                    }
    
                    if ($_FILES['cv']['name'] != "") {
                        $cvName = $_FILES['cv']['name'];
                        $cvTmpName = $_FILES['cv']['tmp_name'];
                        $cvSize = $_FILES['cv']['size'];
    
                        $cvAns = uploadFileCheck($cvName, $cvTmpName, $cvSize, 5000000, array('pdf', 'docx', 'doc'));
    
                        if ($cvAns == '1') {
                            echo json_encode(array("statusCode" => 415, "data" => "File Type Not Allowed"));
                            die();
                        }
                        else if ($cvAns == '2') {
                            echo json_encode(array("statusCode" => 413, "data" => "File Size Too Large"));
                            die();
                        }
                        else {
                            $fileExt = explode('.', $cvName);
                            $fileActualExt = strtolower(end($fileExt));
                            $cvNameNew = uniqid('', true).".".$fileActualExt;
                            $fileDestination = '../../uploads/'.$cvNameNew;
                            move_uploaded_file($cvTmpName, $fileDestination);
                            unlink('../../uploads/'.$cv);

                            $sql = "UPDATE user SET cv = '$cvNameNew' WHERE id = '$id'";
                            $result = $conn->query($sql);
                            echo json_encode(array("statusCode" => 200, "data" => "Information Updated Successfully"));
                        }
                    }
                    die();
                }
                else {
                    echo json_encode(array("statusCode" => 400, "data" => "Bad Request"));
                    die();
                }
            }
            else if ($part == "3") {
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
                        $sql = "DELETE FROM usereducation WHERE userId = '$id'";
                        $conn->query($sql);
                        for ($count = 0; $count < $degreeCount; $count++) {
                            $cleanedDegree = mysqli_real_escape_string($conn, $degree[$count]);
                            $cleanedField = mysqli_real_escape_string($conn, $field[$count]);
                            $cleanedInstituteName = mysqli_real_escape_string($conn, $instituteName[$count]);
                            $cleanedCgpa = mysqli_real_escape_string($conn, $cgpa[$count]);
                            $cleanedEnding = mysqli_real_escape_string($conn, $ending[$count]);

                            $sql = "INSERT INTO usereducation (userId, degreeId, field, instituteName, cgpa, endYear) VALUES ('$id', '$cleanedDegree', '$cleanedField', '$cleanedInstituteName', '$cleanedCgpa', '$cleanedEnding')";
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
            else if ($part == "4") {
                if (isset($_POST['oldPassword']) && isset($_POST['newPassword'])) {
                    $oldPassword = $_POST['oldPassword'];
                    $newPassword = $_POST['newPassword'];

                    $sql = "SELECT id FROM user WHERE id = '$id' AND password = '$oldPassword';";
                    try {
                        $result = $conn->query($sql);
                        if (mysqli_num_rows($result) > 0) {
                            $sql = "UPDATE user SET password = '$newPassword' WHERE id = '$id'";
                            $result = $conn->query($sql);
                            echo json_encode(array("statusCode" => 200, "data" => "Information Updated Successfully"));
                            die();
                        }
                        else {
                            echo json_encode(array("statusCode" => 401, "data" => "Unauthorized Access"));
                            session_destroy();
                            die();
                        }
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