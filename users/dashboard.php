<?php 
    require "navbar.php";
    require "verification.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="/styles/styles.css" rel="stylesheet">
    <script src="/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-3">
                <?php require "../Components/alert.php"; ?>
            </div>
            <div class="col-sm-12 my-4">
                <h2 class="text-center">Dashboard</h2>
            </div>
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-secondary">
                        <thead>
                            <tr>
                                <th scope="col">Company Name</th>
                                <th scope="col">Job Title</th>
                                <th scope="col">Job Type</th>
                                <th scope="col">Job Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "/api/jobapplication/getUser.php",
                type: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        if (data.num == 0) {
                            var tbody = $("tbody");
                            tbody.append("<tr><td colspan='4' class='text-center'>No Data</td></tr>")
                        }
                        else {
                            var tbody = $("tbody");
                            $.each(data.data, function(index, value) {
                                var tr = $("<tr></tr>");
                                tr.append($("<td></td>").text(value.name));
                                tr.append($("<td></td>").text(value.title));
                                tr.append($("<td></td>").text(value.type));
                                tr.append($("<td></td>").text(value.status));
                                tbody.append(tr);
                            })
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
        })
    </script>
</body>
</html>