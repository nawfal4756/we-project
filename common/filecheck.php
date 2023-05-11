<?php 
    function uploadFileCheck($fileName, $tmpName, $size, $sizeAllowed, $allowed) {
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        if (in_array($fileActualExt, $allowed)) {
            if ($size < $sizeAllowed) {
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = '/uploads/'.$fileNameNew;
                move_uploaded_file($tmpName, $fileDestination);
                return $fileNameNew;
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