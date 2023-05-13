<?php
    require "../common/connection.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
        if ($_SESSION['end'] < time()) {
            session_unset();
            session_destroy();
            header("Location: /login.php");
        }

        if ($_SESSION['type'] != "users") {
            header("Location: /login.php");
        }

        $id = $_SESSION['id'];
        $sql = "SELECT completeProfile FROM user WHERE id = $id";
        try {
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if ($row['completeProfile'] == 0) {
                header("Location: /users/information.php");
            }
        }
        catch (Exception $e) {
            //
        }
    }
    else {
        header("Location: /login.php");
    }
?>