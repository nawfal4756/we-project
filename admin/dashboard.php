<?php 
    require "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="../styles/styles.css" rel="stylesheet">
    <script src="../bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-evenly">
            <div class="col-sm-12">
                <?php require "../Components/alert.php"; ?>
            </div>
            <div class="col-sm-12 mb-3">
                <h1 class="text-center">Dashboard</h1>
            </div>
            <div class="col-sm-12 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body" id="user">
                        <h4 class="card-title">Customers</h4>
                        <p>Total Customers: </p>
                        <p>Blocked Customers: </p>
                        <p>Active Customers: </p>
                        <p>Percentage Active: </p>
                    </div>
                    <div class="card-footer">
                        <a href="/admin/view.php/?type=user" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body" id="company">
                        <h4 class="card-title">Company</h4>
                        <p>Total Company: </p>
                        <p>Blocked Company: </p>
                        <p>Active Company: </p>
                        <p>Percentage Active: </p>
                    </div>
                    <div class="card-footer">
                        <a href="/admin/view.php/?type=company" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body" id="employer">
                        <h4 class="card-title">Employers</h4>
                        <p>Total Employers: </p>
                        <p>Blocked Employers: </p>
                        <p>Active Employers: </p>
                        <p>Percentage Active: </p>
                    </div>
                    <div class="card-footer">
                        <a href="/admin/view.php/?type=employers" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body" id="job">
                        <h4 class="card-title">Jobs</h4>
                        <p>Total Jobs: </p>
                        <p>Blocked Jobs: </p>
                        <p>Active Jobs: </p>
                        <p>Percentage Active: </p>
                    </div>
                    <div class="card-footer">
                        <a href="/admin/view.php/?type=job" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "/api/admin/getStats.php",
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        let keys = Object.keys(data.data);
                        keys.forEach((item) => {
                            $("#" + item).find("p").eq(0).append(data.data[item].total);
                            $("#" + item).find("p").eq(1).append(data.data[item].blocked);
                            $("#" + item).find("p").eq(2).append(data.data[item].unblocked);
                            $("#" + item).find("p").eq(3).append(data.data[item].unblocked / data.data[item].total * 100 + "%");
                        })
                    }
                    else if (data.statusCode == 401 || data.statusCode == 403) {
                        showAlert(data.data, "danger");
                        $("body").scrollTop(0);
                        setTimeout(function() {
                            window.location.href = "/admin/index.php";
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
    </script>
</body>
</html>