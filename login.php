<?php
    require "users/navbar.php";
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
    <title>Login</title>

    <link href="/styles/styles.css" rel="stylesheet">
    <script src="/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
</head>
<body>
    <div class="vh-100 bg-secondary">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="card w-25">
                <div class="card-body">
                    <?php include "Components/alert.php" ?>
                    <h4 class="card-title text-center">Log In</h4>
                    <hr>
                    <form id="loginForm" class="needs-validation p-3" novalidate action="#" method="post">
                        <?php 
                            include "Components/inputs.php";
                            inputField("email", "email", "Email Address", "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/");
                            inputField("password", "password", "Password", "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$");
                            checkBoxField("rememberMe", "rememberMe", "Remember Me", false);
                        ?>
                        <div class="mb-3">
                            <a href="signup.php">Don't have an account? Click Here</a> <br>
                            <a href="/employer/login.php">Are you an employer? Click Here</a>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100 text-white">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let form = $("#loginForm")
        
        $(document).ready(function() {
            $("input").change(function() {
                form.addClass("was-validated")
            })

            form.submit(function(e) {
                e.preventDefault()
                form.addClass("was-validated")
                let formData = new FormData(form[0]);

                if (!form[0].checkValidity()) {
                    e.stopPropagation()
                }
                else {
                    let passwordHash = CryptoJS.MD5(formData.get("password")).toString();
                    formData.set("password", passwordHash);
                    $.ajax({
                        url: "/api/users/login.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            console.log("Success", data)
                            if (data.statusCode == 200) {
                                window.location.href = "index.php"
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