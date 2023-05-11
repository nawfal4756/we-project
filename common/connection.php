<?php
    require "realpath.php";
    $env = parse_ini_file($actualPath.".env");
    define("DB_HOST", $env['DB_HOST']);
    define("DB_USERNAME", $env['DB_USERNAME']);
    define("DB_PASSWORD", $env['DB_PASSWORD']);
    define("DB_NAME", $env['DB_NAME']);

    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
?>