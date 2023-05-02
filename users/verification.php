<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['email']) && isset($_SESSION['type'])) {
        if ($_SESSION['end'] < time()) {
            session_unset();
            session_destroy();
            header("Location: /we-project/login.php");
        }

        if ($_SESSION['type'] != "users") {
            header("Location: /we-project/login.php");
        }
    }
    else {
        header("Location: /we-project/login.php");
    }
?>