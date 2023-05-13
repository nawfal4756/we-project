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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
                <div class="col-sm-12 d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center">Profile Picture and CV</h1>
            </div>
        </div>
        <form action="#" class="needs-validation" method="post" id="form2">
            <div class="row d-flex justify-content-evenly">
                <div class="col-sm-12 col-md-6 d-flex justify-content-center">
                    <img src="" alt="Profile Picture" id="profilePic" width="300" height="300">
                </div>
                <div class="col-sm-12 col-md-6">
                    <?php 
                        fileSelectField("profile", "Profile Picture", ".jpg, .jpeg, .png", false);
                    ?>
                    <small>Leave it empty to keep it unchanged</small>
                </div>
                <div class="col-sm-12">
                    <?php 
                        fileSelectField("cv", "CV", ".pdf, .docx", false);
                    ?>
                    <span><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#cvModal">View CV</button></span> <br>
                    <small>Leave it empty to keep it unchanged</small>
                </div>
                <div class="col-sm-12 d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center">Education</h1>
            </div>
        </div>
        <form action="#" class="needs-validation" method="post" id="form3">
            <div class="row d-flex justify-content-evenly" id="education">
                
            </div>
            <div class="col-sm-12 d-flex justify-content-end my-3">
                <button class="btn btn-primary" type="button" id="addDegree"><i class="bi bi-plus-lg"></i> Add</button>
            </div>
            <div class="col-sm-12 d-flex justify-content-end mb-3">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="cvModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">CV</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body vh-100">
                    <object data="" id="cvView" height="100%" width="100%">
                        <p>Unable to display file <a id="cvA" href="">Download</a> instead</p>
                    </object>
                </div>
                <div class="p-3"><a class="btn btn-primary" target="_blank" href="">View on seperate page</a></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let degrees = ""
        function addEducation(data) {
            let html = `
                <hr>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            selectField("degree[]", "Degree", [], "degree");
                        ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            inputField("field[]", "text", "Field");
                        ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            inputField("instituteName[]", "text", "Institute Name");
                        ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            inputField("cgpa[]", "text", "CGPA");
                        ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php 
                            dateField("ending[]", "Graduation Year");
                        ?>
                    </div>
                    <div class="col-sm-12 d-flex justify-content-end mb-3">
                        <button class="btn btn-danger educationDelete" type="button">Remove</button>
                    </div>
                </div>
            `;
            
            $(html).appendTo("#education");
            for (let i = 0; i < degrees.length; i++) {
                $("#education").children().last().find("select[name='degree[]']").append(`<option value="${degrees[i].id}">${degrees[i].name}</option>`);
            }
            $("#education").children().last().find("select[name='degree[]']").val(data.degreeId);
            $("#education").children().last().find("input[name='field[]']").val(data.field);
            $("#education").children().last().find("input[name='instituteName[]']").val(data.instituteName);
            $("#education").children().last().find("input[name='cgpa[]']").val(data.cgpa);
            $("#education").children().last().find("input[name='ending[]']").val(`${data.endYear}-01-01`);
        }

        function getUserData() {
            $.ajax({
                url: "/api/users/getInfo.php",
                type: "GET",
                success: function(response) {
                    if (response.statusCode == 200) {
                        let data = response.data;
                        console.log(data)
                        $("#name").val(data.name);
                        $("#email").val(data.email);
                        $("#phone").val(data.phone);
                        $("#dob").val(data.dob);
                        $("#specialization").val(data.specialization);
                        $("#skills").val(data.skills);
                        $("#skills").trigger("change");
                        $("#profilePic").attr("src", `../uploads/${data.profilePic}`);
                        $("#cvView").attr("data", `/uploads/${data.cv}`);
                        $(".modal-body") > $("a").attr("href", `/uploads/${data.cv}`);
                        $("#education").html("")
                        data.education.forEach((education) => {
                            addEducation(education);
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
        }

        $(document).ready(function() {
            $.ajax({
                url: "/api/degree/getAll.php",
                type: "GET",
                success: function(response) {
                    if (response.statusCode == 200) {
                        degrees = response.data
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

            getUserData()

            $("form").submit(function(e) {
                e.preventDefault();
                $(this).addClass("was-validated");
                if (!$(this)[0].checkValidity()) {
                    e.stopPropagation();
                }

                let formData = new FormData(this);
                let formId = $(this).attr("id");
                if (formId == "form1") {
                    formData.append("part", "1")
                }
                else if (formId == "form2") {
                    formData.append("part", "2")
                }
                else if (formId == "form3") {
                    formData.append("part", "3")
                }
                $.ajax({
                    url: "/api/users/update.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log("Success", response);
                        if (response.statusCode == 200) {
                            $("body").scrollTop(0);
                            showAlert(response.data, "success");
                            getUserData();
                        }
                        else {
                            showAlert(response.data, "danger");
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("Error", errorThrown)
                        showAlert(errorThrown, "danger")
                    }
                })
            })

            $(document).on("click", ".educationDelete", function() {
                $(this).parent().parent().remove();
            })

            $("#addDegree").click(function() {
                addEducation({});
            })
        })
    </script>
</body>
</html>