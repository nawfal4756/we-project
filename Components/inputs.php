<?php 
    function inputField($name, $type, $title, $regex = '.*', $required = true, $value = null) {
        if ($required) {
            echo "<div class='form-floating mb-3'>
                <input type='$type' class='form-control' name='$name' id='$name' placeholder='Hello' value='$value' pattern='$regex' required>
                <label for='$name'>$title</label>
                <div class='valid-feedback'>
                    Looks good!
                </div>
                <div class='invalid-feedback'>
                    Please enter a valid $title.
                </div>
            </div>";
        }
        else {
            echo "<div class='form-floating mb-3'>
                <input type='$type' class='form-control' name='$name' id='$name' placeholder='Hello' value='$value'>
                <label for='$name'>$title</label>
                <div class='valid-feedback'>
                    Looks good!
                </div>
                <div class='invalid-feedback'>
                    Please enter a valid $title.
                </div>
            </div>";
        }
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

    function dateField($name, $title) {
        echo "<div class='mb-3'>
                <label for='$name' class='form-label'>$title</label>
                <input type='date' name='$name' id='$name' class='form-control' required>
                <div class='valid-feedback'>
                    Looks good!
                </div>
                <div class='invalid-feedback'>
                    Please enter a valid $title.
                </div>
            </div>";
    }

    function fileSelectField($name, $title, $fileTypesAllowed, $required = true) {
        if ($required) {
            echo "<div class='mb-3'>
                    <label for='$name' class='form-label'>$title</label>
                    <input class='form-control' type='file' id='$name' name='$name' accept='$fileTypesAllowed' required>
                    <div class='valid-feedback'>
                        Looks good!
                    </div>
                    <div class='invalid-feedback'>
                        Please select a valid $title.
                    </div>
                </div>";
        }
        else {
            echo "<div class='mb-3'>
                    <label for='$name' class='form-label'>$title</label>
                    <input class='form-control' type='file' id='$name' name='$name' accept='$fileTypesAllowed'>
                </div>";
        }
    }

    function fancySelect($name, $title, $options, $id = null) {
        $actualId = $id ?? $name;
        echo "<div class='mb-3'>
                <label for='$name' class='form-label'>$title</label>
                <select class='form-select js-example-basic-multiple' name='$name' id='$actualId' multiple='multiple' style='width: 100%;'>
        ";
                    foreach ($options as $option) {
                        echo "<option value='$option->id'>$option->name</option>";
                    }
    
        echo "</select>
                <div class='valid-feedback'>
                    Looks good!
                </div>
                <div class='invalid-feedback'>
                    Please select valid $title.
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('.js-example-basic-multiple').select2();
                });
            </script>";
    }

    function selectField($name, $title, $options, $id = null) {
        $actualId = $id ?? $name;
        echo "<div class='mb-3'>
                <label for='$name' class='form-label'>$title</label>
                <select class='form-select' name='$name' id='$actualId' required>
                    <option selected disabled>Select $title</option>";
                    foreach ($options as $option) {
                        echo "<option value='$option->id'>$option->name</option>";
                    }
                echo "</select>
                <div class='valid-feedback'>
                    Looks good!
                </div>
                <div class='invalid-feedback'>
                    Please select a valid $title.
                </div>
            </div>";
    }
?>