<?php 
    $path = realpath(__DIR__);
    $pathArr = explode("\\", $path);
    $actualPath = "";
    for ($i = 0; $i < 4; $i++) {
        $actualPath .= $pathArr[$i] . "/";
    }
?>