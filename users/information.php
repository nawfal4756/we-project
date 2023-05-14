<?php
    require "navbar.php";
    require "verification.php";
    if ($completeProfile) {
        header("Location: /users/dashboard.php");
    }

    require "../Components/inputs.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>

    <link href="/styles/styles.css" rel="stylesheet">
    <script src="/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 my-3">
                <div class="progress" role="progressbar">
                    <div class="progress-bar bg-secondary" style="width: 0%">0%</div>
                </div>
            </div>
            <div class="col-sm-12 mb-3">
                <h1 class="text-center">User Details</h1>
            </div>
            <div class="col-sm-12">
                <?php require "../Components/alert.php"; ?>
            </div>
        </div>
        <div class="row" id="part1">
            <div class="col-sm-12">
                <form id="form1" action="#" method="post" class="needs-validation" novalidate>
                    <?php 
                        inputField("specialization", "text", "Specialization");
                        dateField("dob", "Date of Birth");
                    ?>
                    <div class="mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit" id="part1Next">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" id="part2" style="display: none;">
            <div class="col-sm-12">
                <form id="form2" action="#" method="post" class="needs-validation" novalidate>
                    <?php
                        fileSelectField("profile", "Profile Picture", ".jpg, .jpeg, .png");
                        fileSelectField("cv", "CV", ".pdf, .docx");
                    ?>
                    
                    <div class="mb-3 d-flex justify-content-between">
                        <button class="btn btn-primary" type="button" id="part2Back"><i class="bi bi-arrow-left"></i> Back</button>
                        <button class="btn btn-primary" type="submit" id="part2Next">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" id="part3" style="display: none;">
            <div class="col-sm-12">
                <form id="form3" action="#" method="post" class="needs-validation" novalidate>
                    <div id="degreeForm">
                        <div id="degreeFields">
                            <?php 
                                selectField("degree[]", "Degree", [], "degree");
                                inputField("field[]", "text", "Field");
                                inputField("instituteName[]", "text", "Institute Name");
                                inputField("cgpa[]", "text", "CGPA");
                                dateField("ending[]", "Graduation Year");
                            ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" type="button" id="addDegree"><i class="bi bi-plus"></i> Add</button>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <button class="btn btn-primary" type="button" id="part3Back"><i class="bi bi-arrow-left"></i> Back</button>
                        <button class="btn btn-primary" type="submit" id="part3Next">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" id="part4" style="display: none;">
            <div class="col-sm-12">
                <form id="form4" action="#" method="post" class="needs-validation" novalidate>
                    <?php 
                        fancySelect("skills[]", "Skills", [], "skills")
                    ?>
                    
                    <div class="mb-3 d-flex justify-content-between">
                        <button class="btn btn-primary" type="button" id="part4Back"><i class="bi bi-arrow-left"></i> Back</button>
                        <button class="btn btn-primary" type="submit" id="part4Next">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let form1 = $("#form1");
        let form2 = $("#form2");
        let form3 = $("#form3");
        let form4 = $("#form4");

        function part1Next() {
            $("#part1").hide();
            $("#part2").show();
            $(".progress-bar").css("width", "25%");
            $(".progress-bar").text("25%");
        }

        function part2Next() {
            $("#part2").hide();
            $("#part3").show();
            $(".progress-bar").css("width", "50%");
            $(".progress-bar").text("50%");
        }

        function part3Next() {
            $("#part3").hide();
            $("#part4").show();
            $(".progress-bar").css("width", "75%");
            $(".progress-bar").text("75%");
        }

        function part2Back() {
            $("#part2").hide();
            $("#part1").show();
            $(".progress-bar").css("width", "0%");
            $(".progress-bar").text("0%");
        }

        function part3Back() {
            $("#part3").hide();
            $("#part2").show();
            $(".progress-bar").css("width", "25%");
            $(".progress-bar").text("25%");
        }

        function part4Back() {
            $("#part4").hide();
            $("#part3").show();
            $(".progress-bar").css("width", "50%");
            $(".progress-bar").text("50%");
        }

        $(document).ready(function() {
            $.ajax({
                url: "/api/degree/getAll.php",
                type: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        data.data.forEach(degree => {
                            $("#degree").append(`<option value="${degree.id}">${degree.name}</option>`);
                        });
                    }
                    else if (data.statusCode == 401 || data.statusCode == 403) {
                        showAlert(data.data, "danger");
                        $("body").scrollTop(0);
                        setTimeout(function() {
                            window.location.href = "/login.php";
                        }, 2000);
                    }
                    else {
                        showAlert(data.data, "danger");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert(errorThrown, "danger")
                }
            })

            $.ajax({
                url: "/api/skills/getAll.php",
                type: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        $("#skills").select2({
                            data: data.data
                        });
                    }
                    else if (data.statusCode == 401 || data.statusCode == 403) {
                        showAlert(data.data, "danger");
                        $("body").scrollTop(0);
                        setTimeout(function() {
                            window.location.href = "/login.php";
                        }, 2000);
                    }
                    else {
                        showAlert(data.data, "danger");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert(errorThrown, "danger")
                }
            })

            $("#addDegree").click(function() {
                $("#degreeForm").append($("#degreeFields").html());
            })

            $(document).on("click", ".degreeRemove", function() {
                $(this).parent().remove();
            })

            $("form").submit(function(e) {
                e.preventDefault();
                $(this).addClass("was-validated");
                let formData = new FormData($(this)[0]);
                let form = 0;
                if (!$(this)[0].checkValidity()) {
                    e.stopPropagation();
                }
                else {
                    if ($(this).attr("id") == "form1") {
                        formData.append("part", "1");
                        form = 1;
                    }
                    else if ($(this).attr("id") == "form2") {
                        formData.append("part", "2");
                        form = 2;
                    }
                    else if ($(this).attr("id") == "form3") {
                        formData.append("part", "3");
                        form = 3;
                    }
                    else if ($(this).attr("id") == "form4") {
                        formData.append("part", "4");
                        form = 4;
                    }

                    // for debugging
                    // if (form == 1) {
                    //     part1Next();
                    // }
                    // else if (form == 2) {
                    //     part2Next();
                    // }
                    // else if (form == 3) {
                    //     part3Next();
                    // }
                    // else if (form == 4) {
                    //     alert("done");
                    // }

                    $.ajax({
                        url: "/api/users/information.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        enctype: 'multipart/form-data',
                        success: function(data) {
                            if (data.statusCode == 200) {
                                if (form == 1) {
                                    part1Next();
                                }
                                else if (form == 2) {
                                    part2Next();
                                }
                                else if (form == 3) {
                                    part3Next();
                                }
                                else if (form == 4) {
                                    window.location.href = "/index.php";
                                }
                            }
                            else if (data.statusCode == 401 || data.statusCode == 403) {
                                showAlert(data.data, "danger");
                                $("body").scrollTop(0);
                                setTimeout(function() {
                                    window.location.href = "/login.php";
                                }, 2000);
                            }
                            else {
                                showAlert(data.data, "danger");
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            showAlert(errorThrown, "danger")
                        }
                    })
                }
            })

            $("#part2Back").click(function() {
                part2Back();
            })

            $("#part3Back").click(function() {
                part3Back();
            })

            $("#part4Back").click(function() {
                part4Back();
            })
        })
    </script>
</body>
</html>