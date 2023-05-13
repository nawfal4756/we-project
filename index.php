<?php 
    require "users/navbar.php";
    require "common/connection.php";
    require "Components/inputs.php";
    
    // if (isset($_SESSION['id'])) {
    //     $id = $_SESSION['id'];
    //     $sql = "SELECT completeProfile FROM user WHERE id = $id";
    //     try {
    //         $result = $conn->query($sql);
    //         $row = $result->fetch_assoc();
    //         if ($row['completeProfile'] == 0) {
    //             header("Location: /users/information.php");
    //         }
    //     }
    //     catch (Exception $e) {
    //         //
    //     }
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="styles/styles.css" rel="stylesheet">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 my-4">
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
                                fancySelect("skills[]", "Skills", array((object)['id'=> 1, 'name'=>'PHP'], (object)['id'=> 2, 'name'=>'JavaScript']))
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
            <div class="col-sm-12 col-md-6 mb-3">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-4">
                            <img src="" alt="Company Logo">
                        </div>
                        <div class="col-sm-8">
                            <div class="card-body">
                                <h5 class="card-title">Job Title</h5>
                                <p class="card-text">Job Description Here</p>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-4">
                            <img src="" alt="Company Logo">
                        </div>
                        <div class="col-sm-8">
                            <div class="card-body">
                                <h5 class="card-title">Job Title</h5>
                                <p class="card-text">Job Description Here</p>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                                <a href=""><span class="badge bg-secondary">Skill</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getData(dataString) {
            $.ajax({
                url: "/api/jobs/getAll.php/?"+dataString,
                type: "GET",
                success: function(data) {
                    console.log(data)
                }
            })
        }

        $(document).ready(function() {
            let mainUrl = window.location.href
            let urlSplitted = mainUrl.split("?")
            let data = ""
            if (urlSplitted[1]) {
                data = urlSplitted[1]
            }
            getData(data)

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
                console.log(serializedData)
                let url = window.location.href
                let urlSplitted = url.split("?")
                let newUrl = urlSplitted[0] + "?" + serializedData
                history.pushState(null, null, newUrl)
                getData(serializedData)
            })
        })

    </script>
</body>
</html>