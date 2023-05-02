<?php 
    function inputField($name, $type, $title) {
        echo "<div class='form-floating mb-3'>
            <input type='$type' class='form-control' name='$name' id='$name' placeholder='Hello' required>
            <label for='$name'>$title</label>
            <div class='valid-feedback'>
                Looks good!
            </div>
            <div class='invalid-feedback'>
                Please enter a valid $title.
            </div>
        </div>";
    }

    function checkBoxField($name, $value, $title, $required, $incorrectValidationMessage = 'Please check this box') {
        if ($required) {
            echo "<div class='form-check mb-3'>
                    <input type='checkbox' name='$name' value='$value' class='form-check-input' id='$name' required>
                    <label for='$name' class='form-check-label'>$title</label>
                    <div class='valid-feedback'>
                        Looks good!
                    </div>
                    <div class='invalid-feedback'>
                        $incorrectValidationMessage
                    </div>
                </div>";
        }
        else {
            echo "<div class='form-check mb-3'>
                    <input type='checkbox' name='$name' value='$value' class='form-check-input' id='$name'>
                    <label for='$name' class='form-check-label'>$title</label>
                </div>";
        }
    }
?>