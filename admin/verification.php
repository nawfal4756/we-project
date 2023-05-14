<?php
    require "../common/connection.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
        if ($_SESSION['end'] < time()) {
            session_unset();
            session_destroy();
            header("Location: /admin/index.php");
        }

        if ($_SESSION['type'] != "admin") {
            header("Location: /admin/index.php");
        }

        $id = $_SESSION['id'];
        $sql = "SELECT blocked FROM admin WHERE id = $id";
        $completeProfile = false;
        try {
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['blocked'] == 1) {
                session_unset();
                session_destroy();
                header("Location: /admin/index.php");
            }
        }
        catch (Exception $e) {
            //
        }
    }
    else {
        header("Location: /admin/index.php");
    }
?>