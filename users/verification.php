<?php 
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
    }
    else {
        header("Location: /login.php");
    }
?>