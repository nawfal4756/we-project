<?php 
    require "navbar.php";
    require "verification.php";
    require "../Components/inputs.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>

    <link href="/styles/styles.css" rel="stylesheet">
    <script src="/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php require "../Components/alert.php"; ?>
            </div>
            <div class="col-sm-12 my-4">
                <h1 class="text-center">My Account</h1>
            </div>
        </div>
        <hr>
        <form action="#" class="needs-validation" method="post" id="form1">
                <div class="row d-flex justify-content-evenly">
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            inputField("name", "text", "Name");
                        ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            inputField("email", "text", "Email");
                        ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            inputField("phone", "text", "Phone");
                        ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            inputField("dob", "date", "Date of Birth");
                        ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            inputField("specialization", "text", "Specialization");
                        ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            fancySelect("skills[]", "Skills", [], "skills");
                        ?>
                    </div>
                    <div class="col-sm-12 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </div>
            </form>
            <hr>
            <form action="#" class="needs-validation" method="post" id="form2">

            </form>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "/api/skills/getAll.php",
                type: "GET",
                success: function(response) {
                    if (response.statusCode == 200) {
                        $("#skills").empty();
                        response.data.forEach((skill) => {
                            $("#skills").append(`<option value="${skill.id}">${skill.name}</option>`);
                        })
                    }
                    else {
                        showAlert(response.data, "danger");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert(errorThrown, "danger")
                }
            })

            $.ajax({
                url: "/api/users/getInfo.php",
                type: "GET",
                success: function(response) {
                    if (response.statusCode == 200) {
                        var data = response.data;
                        $("#name").val(data.name);
                        $("#email").val(data.email);
                        $("#phone").val(data.phone);
                        $("#dob").val(data.dob);
                        $("#specialization").val(data.specialization);
                        $("#skills").val(data.skills);
                        $("#skills").trigger("change");
                    }
                    else {
                        showAlert(response.data, "danger");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert(errorThrown, "danger")
                }
            })
        })
    </script>
</body>
</html>