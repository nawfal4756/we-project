<?php 
    function uploadFileCheck($fileName, $tmpName, $size, $sizeAllowed, $allowed) {
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        if (in_array($fileActualExt, $allowed)) {
            if ($size < $sizeAllowed) {
                return '0';
            }
            else {
                return '2';
            }
        }
        else {
            return '1';
        }
    }
?>