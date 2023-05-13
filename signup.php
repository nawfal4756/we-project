<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['id'])) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <link href="styles/styles.css" rel="stylesheet">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
</head>
</head>
<body class="bg-secondary">
    <div>
        <?php require "users/navbar.php"; ?>
        <div class="d-flex justify-content-center align-items-center mt-5">
            <div class="card w-25">
                <div class="card-body">
                    <?php include "Components/alert.php" ?>
                    <h4 class="card-title text-center">Sign Up</h4>
                    <hr>
                    <form id="signupForm" class="needs-validation p-3" novalidate action="#" method="post">
                        <?php 
                            require "Components/inputs.php";
                            inputField("name", "text", "Name");
                            inputField("email", "email", "Email Address");
                            inputField("phone", "text", "Phone Number");
                        ?>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label> <br>
                            <div class="form-check">
                                <input type="radio" name="gender" id="male" value="Male" class="form-check-input" required>
                                <label for="male" class="form-check-label">Male</label>
                            </div>
                            <div class="form-check mb-3">
                                <input type="radio" name="gender" id="female" value="Female" class="form-check-input" required>
                                <label for="female" class="form-check-label">Female</label>
                                <div class='invalid-feedback'>
                                    Please select a gender
                                </div>
                            </div>
                        </div>
                        <?php
                            inputField("password", "password", "Password");
                            inputField("confirmPassword", "password", "Confirm Password");
                            checkBoxField("terms", "terms", "I agree to the terms and conditions", true, "Please agree to the terms and conditions");
                        ?>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100" id="signUp">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let form = $("#signupForm");
        let signUpBtn = $("#signUp")

        $(document).ready(function() {
            form.submit(function(e) {
                e.preventDefault()
                form.addClass('was-validated');
                let formData = new FormData(this);

                if (!form[0].checkValidity() || formData.get('password') != formData.get('confirmPassword')) {
                    e.stopPropagation();
                    if (formData.get('password') != formData.get('confirmPassword')) {
                        showAlert("Passwords do not match", "danger")
                    }
                }
                else {
                    let passwordHash = CryptoJS.MD5(formData.get("password")).toString();
                    formData.set("password", passwordHash);
                    $.ajax({
                        url: "/api/users/signup.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            console.log("Success", data)
                            if (data.statusCode == 200) {
                                form.removeClass('was-validated');
                                form[0].reset()
                                signUpBtn.slideUp()
                                showAlert(data.data, "success")
                                setTimeout(function() {
                                    window.location.href = "login.php"
                                }, 2000)
                            }
                            else {
                                showAlert(data.data, "danger")
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("Error", errorThrown)
                            showAlert(errorThrown, "danger")
                        }
                    })
                }
            })
        })
    </script>
</body>
</html>