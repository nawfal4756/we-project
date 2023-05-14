<?php 
    require "../users/navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>

    <link href="/styles/styles.css" rel="stylesheet">
    <script src="/bootstrap-5.3.0-alpha3-dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php require "../Components/alert.php"; ?>
            </div>
            <div class="col-sm-12 mb-3">
                <h1 class="text-center" id="title"></h1>
            </div>
        </div>
        <div class="row">
        <div class="col-sm-12 col-md-6 mb-3">
                <h3>Comapny Name</h3>
                <p id="name"></p>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <h3>Description</h3>
                <pre id="description"></pre>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <h3>Salary</h3>
                <p id="salary"></p>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <h3>Location</h3>
                <p id="location"></p>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <h3>Type</h3>
                <p id="type"></p>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <h3>Skills</h3>
                <p id="skills"></p>
            </div>
            <div class="col-sm-12 d-flex justify-content-between mb-3">
                <a class="btn btn-secondary" href="/"><i class="bi bi-arrow-left"></i> Back</a>
                <button class="btn btn-primary" id="apply">Apply</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let url = new URL(window.location.href);
            let params = new URLSearchParams(url.search);
            let id = params.get("id");
            let completeData = null;

            $.ajax({
                url: "/api/jobs/getJob.php",
                type: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data.statusCode == 200) {
                        let job = data.data
                        completeData = job;
                        $("#title").html(job.title);
                        $("#name").html(job.name);
                        $("#description").html(job.requirements);
                        $("#salary").html(job.minSalary + " - " + job.maxSalary);
                        $("#location").html(job.location);
                        $("#type").html(job.type);
                        $("#skills").html(job.skills.join(", "));
                    }
                    else {
                        showAlert(data.data, "danger")
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showAlert(errorThrown, "danger")
                }
            })

            $("#apply").click(function() {
                $.ajax({
                    url: "/api/jobs/apply.php",
                    type: "POST",
                    data: {
                        jobId: id,
                        companyId: completeData.companyId
                    },
                    success: function(data) {
                        if (data.statusCode == 200) {
                            $("#apply").attr("disabled", true);
                            showAlert(data.data, "success")
                            setTimeout(function() {
                                window.location.href = "/";
                            }, 2000)
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