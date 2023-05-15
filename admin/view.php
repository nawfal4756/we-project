<?php 
    require "navbar.php";
    require "../Components/inputs.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="title">Dashboard</title>

    <link href="/styles/styles.css" rel="stylesheet">
    <script src="/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php require "../Components/alert.php"; ?>
            </div>
            <div class="col-sm-12 mb-3">
                <h1 class="text-center" id="heading"></h1>
            </div>
            <div class="col-sm-12 d-flex justify-content-end mb-3">
                <button type="button" id="addBtn" data-bs-toggle="modal" data-bs-target="#addAdminModal" class="btn btn-primary" style="display: none;"><i class="bi bi-plus"></i> Add</button>
            </div>
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addAdminModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Add Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="addAdminForm" class="needs-validation">
                    <div class="modal-body">
                            <?php 
                                inputField("name", "text", "Name");
                                inputField("email", "email", "Email");
                                inputField("phone", "text", "Phone Number");
                                inputField("password", "password", "Password");
                                inputField("rePassword", "password", "Re-Enter Password");
                            ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function tableColumns(type) {
            if (type == "company") {
                return ["ID", "Name", "Location", "Status", "Action"];
            }
            else if (type == "employers" || type == "user" || type == "admin") {
                return ["ID", "Name", "Email", "Status", "Action"];
            }
            else if (type == "job") {
                return ["ID", "Title", "Company", "Status", "Action"];
            }
        }

        function getData(type) {
            $.ajax({
                url: "/api/admin/getData.php",
                type: "GET",
                data: {
                    type: type
                },
                success: function(data) {
                    if (data.statusCode == 200) {
                        $("tbody").empty()
                        if (data.num == 0) {
                            $("tbody").append("<tr><td colspan='5' class='text-center'>No data found</td></tr>")
                        }
                        let rows = data.data;
                        if (type == "company") {
                            rows.forEach((item) => {
                                $("tbody").append(
                                    `<tr>
                                        <td>${item.id}</td>
                                        <td>${item.name}</td>
                                        <td>${item.location}</td>
                                        <td class="text-${item.blocked == 0 ? "success" : "danger"}">${item.blocked == 0 ? "Active" : "Blocked"}</td>
                                        <td>
                                            <a class="btn btn-${item.blocked == 0 ? "danger" : "primary"} blockBtn" data="${item.id}-${item.blocked}">${item.blocked == 0 ? "Block" : "Unblock"}</a>
                                        </td>
                                    </tr>`
                                )
                            })
                        }
                        else if (type == "employers" || type == "user" || type == "admin") {
                            rows.forEach((item) => {
                                $("tbody").append(
                                    `<tr>
                                        <td>${item.id}</td>
                                        <td>${item.name}</td>
                                        <td>${item.email}</td>
                                        <td class="text-${item.blocked == 0 ? "success" : "danger"}">${item.blocked == 0 ? "Active" : "Blocked"}</td>
                                        <td>
                                            <a class="btn btn-${item.blocked == 0 ? "danger" : "primary"} blockBtn" data="${item.id}-${item.blocked}">${item.blocked == 0 ? "Block" : "Unblock"}</a>
                                        </td>
                                    </tr>`
                                )
                            })
                        }
                        else if (type == "job") {
                            rows.forEach((item) => {
                                $("tbody").append(
                                    `<tr>
                                        <td>${item.id}</td>
                                        <td>${item.title}</td>
                                        <td>${item.name}</td>
                                        <td class="text-${item.blocked == 0 ? "success" : "danger"}">${item.blocked == 0 ? "Active" : "Blocked"}</td>
                                        <td>
                                            <a class="btn btn-${item.blocked == 0 ? "danger" : "primary"} blockBtn" data="${item.id}-${item.blocked}">${item.blocked == 0 ? "Block" : "Unblock"}</a>
                                        </td>
                                    </tr>`
                                )
                            })
                        }
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
        }

        $(document).ready(function() {
            let url = new URL(window.location.href);
            let type = url.searchParams.get("type");
            if (!type) {
                window.location.href = "/admin/dashboard.php";
            }
            if (type != "company" && type != "employers" && type != "user" && type != "job" && type != "admin") {
                window.location.href = "/admin/dashboard.php";
            }
            if (type == "admin") {
                $("#addBtn").show();
            }
            let typeTitleCase = type.charAt(0).toUpperCase() + type.slice(1);
            $("#heading").text(typeTitleCase + " Dashboard")
            $("#title").text(typeTitleCase)
            $("thead").append("<tr></tr>")
            let columns = tableColumns(type);
            for (let i = 0; i < columns.length; i++) {
                $("thead tr").append("<th>" + columns[i] + "</th>")
            }
            getData(type);

            $(document).on("click", ".blockBtn", function() {
                let data = $(this).attr("data").split("-");
                let id = data[0];
                let blocked = data[1];
                
                $.ajax({
                    url: "/api/admin/blocking.php",
                    type: "POST",
                    data: {
                        type: type,
                        id: id,
                        blocked: blocked
                    },
                    success: function(data) {
                        if (data.statusCode == 200) {
                            getData(type);
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

            $("#addAdminForm").submit(function(e) {
                e.preventDefault();
                let form = $(this);
                form.addClass('was-validated');
                if (!form[0].checkValidity()) {
                    e.stopPropagation()
                }
                else {
                    let formData = new FormData(this);
                    if (formData.get("password") != formData.get("rePassword")) {
                        showAlert("Password and Confirm Password does not match", "danger");
                        return;
                    }
                    let passwordHash = CryptoJS.MD5(formData.get("password")).toString();
                    formData.set("password", passwordHash);
                    formData.delete("rePassword");
                    $.ajax({
                        url: "/api/admin/addAdmin.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            $("#addAdminModal").modal("toggle")
                            if (data.statusCode == 200) {
                                showAlert(data.data, "success");
                                $("body").scrollTop(0);
                                getData(type);
                                form.removeClass('was-validated');
                                form[0].reset()
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
                }
            })
        })
    </script>
</body>
</html>