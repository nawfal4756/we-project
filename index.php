<?php 
    require "users/navbar.php";
    require "common/connection.php";
    require "Components/inputs.php";

    if (isset($_SESSION['id'])) {
        if ($_SESSION['type'] == "users") {
            $id = $_SESSION['id'];
            $sql = "SELECT completeProfile FROM user WHERE id = $id";
            try {
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                if ($row['completeProfile'] == 0) {
                    header("Location: /users/information.php");
                }
            }
            catch (Exception $e) {
                //
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="/styles/styles.css" rel="stylesheet">
    <script src="/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 my-4">
                <?php require "Components/alert.php"; ?>
            </div>
            <div class="col-sm-12 mb-3">
                <h1 class="text-center">Recent Jobs Posted</h1>
            </div>
            <div class="col-sm-12 mb-3">
                <div class="accordion" id="searchAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="accordionHeading">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Search
                      </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="accordionHeading" data-bs-parent="#searchAccordion">
                      <div class="accordion-body">
                        <form action="#" method="get">
                            <?php 
                                inputField("keyword", "text", "Keyword", false);
                                inputField("minSalary", "text", "Min Salary", false);
                                inputField("maxSalary", "text", "Max Salary", false);
                                inputField("location", "text", "Location", false);
                                inputField("type", "text", "Type", false);
                                fancySelect("skills[]", "Skills", [], "skills")
                            ?>
                            <div class="mb-3">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-evenly" id="jobs">
            
        </div>
    </div>

    <script>
        function getData(dataString) {
            $.ajax({
                url: "/api/jobs/getAll.php/?"+dataString,
                type: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        if (data.num == 0) {
                            $("#jobs").html("")
                            $("#jobs").append(`
                                <div class="col-sm-12">
                                    <h2 class="text-center">No Jobs Found</h2>
                                </div>
                            `)
                            return;
                        } 
                        $("#jobs").html("")
                        let jobs = data.data
                        jobs.forEach((job) => {
                            $("#jobs").append(`
                            <div class="col-sm-12 col-md-6 mb-3">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-sm-4 d-flex justify-content-center align-items-center">
                                            <img src="/uploads/${job.logo}" alt="Company Logo">
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="card-body">
                                                <h5 class="card-title">${job.title}</h5>
                                                <p class="card-text">${job.companyName}</p>
                                                <p class="card-text">${job.location}</p>
                                                <p class="card-text">${job.type}</p>
                                                <p class="card-text">${job.minSalary} - ${job.maxSalary}</p>
                                                ${job.skills.map((skill) =>{
                                                    return `<span class="badge bg-secondary">${skill}</span>`
                                                })}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <a class="btn btn-secondary mx-2" href="/jobs/view.php/?id=${job.id}">View</a>
                                        <a class="btn btn-primary applyJob" id="${job.id}-${job.companyId}">Apply</a>
                                    </div>
                                </div>
                            </div>
                            `)
                        })
                    }
                    else if (data.statusCode == 401 || data.statusCode == 403) {
                        showAlert(data.data, "danger");
                        $("body").scrollTop(0);
                        setTimeout(function() {
                            window.location.href = "/login.php";
                        }, 2000);
                    }
                    else {
                        showAlert(data.data, "danger")
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert(errorThrown, "danger")
                }
            })
        }

        function getSkills() {
            $.ajax({
                url: "/api/skills/getAll.php",
                type: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        let skills = data.data
                        $("#skills").select2({
                            data: skills
                        })
                    }
                    else if (data.statusCode == 401 || data.statusCode == 403) {
                        showAlert(data.data, "danger");
                        $("body").scrollTop(0);
                        setTimeout(function() {
                            window.location.href = "/login.php";
                        }, 2000);
                    }
                    else {
                        showAlert(data.data, "danger")
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert(errorThrown, "danger")
                }
            })
        }

        function checkParameter() {
            let mainUrl = window.location.href
            let urlSplitted = mainUrl.split("?")
            let data = ""
            if (urlSplitted[1]) {
                data = urlSplitted[1]
            }
            getData(data)
        }

        $(document).ready(function() {
            checkParameter()
            getSkills()

            $("form").submit(function(e) {
                e.preventDefault()
                
                let formData = new FormData(this)
                if (formData.get("keyword") == "") {
                    formData.delete("keyword")
                }
                if (formData.get("minSalary") == "") {
                    formData.delete("minSalary")
                }
                if (formData.get("maxSalary") == "") {
                    formData.delete("maxSalary")
                }
                if (formData.get("location") == "") {
                    formData.delete("location")
                }
                if (formData.get("type") == "") {
                    formData.delete("type")
                }
                if (formData.get("skills[]") == "") {
                    formData.delete("skills[]")
                }
                let serializedData = new URLSearchParams(formData).toString()
                let url = window.location.href
                let urlSplitted = url.split("?")
                let newUrl = urlSplitted[0] + "?" + serializedData
                history.pushState(null, null, newUrl)
                getData(serializedData)
            })

            $(document).on("click", ".applyJob", function() {
                let id = $(this).attr("id")
                let splittedId = id.split("-")
                let jobId = splittedId[0]
                let companyId = splittedId[1]
                let data = {
                    jobId: jobId,
                    companyId: companyId
                }
                $.ajax({
                    url: "/api/jobs/apply.php",
                    type: "POST",
                    data: data,
                    success: function(data) {
                        if (data.statusCode == 200) {
                            showAlert(data.data, "success")
                            checkParameter()
                        }
                        else if (data.statusCode == 401 || data.statusCode == 403) {
                            showAlert(data.data, "danger");
                            $("body").scrollTop(0);
                            setTimeout(function() {
                                window.location.href = "/login.php";
                            }, 2000);
                        }
                        else {
                            showAlert(data.data, "danger")
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        showAlert(errorThrown, "danger")
                    }
                })
            
            })
        })

    </script>
</body>
</html>