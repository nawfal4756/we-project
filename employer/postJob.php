
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="../styles/styles.css" rel="stylesheet">
    <link href="../styles/employer.css" rel="stylesheet">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-secondary">
    <!-- navbar -->
    <div>
        <?php require "navbar.php" ?>;
    </div>

    <!-- post job -->
    <div class="container card-0 justify-content-center ">
  <div class="card-body px-sm-4 px-0">
    <div class="row justify-content-center mb-5">
      <div class="col-md-10 col">
        <h3 class="font-weight-bold ml-md-0 mx-auto text-center text-sm-left"> Post a Job </h3>
      </div>
    </div>
    <div class="row justify-content-center round">
      <div class="col-lg-10 col-md-12 ">
        <div class="card shadow-lg card-1">
          <div class="card-body inner-card">
            <div class="row justify-content-center">
              <div class="col-lg-5 col-md-6 col-sm-12">
              <form id="postJob" method="post" class="needs-validation p-3" novalidate action="#">
                <div class="form-group">
                  <label for="first-name">Enter job title : </label>
                  <input type="text" class="form-control" id="job-title" placeholder="job title">
                </div>
                <div class="form-group">
                  <label for="Mobile-Number"> Enter job location : </label>
                  <input type="text" class="form-control" id="job-loc" placeholder="job location">
                </div>
                <div class="form-group">
                    <label for="jobType">Choose job type</label>
                    <select class="form-control" id="jobType" name="jobType" required>
                        <option value="">Select an option</option>
                        <option value="OnSite">On Site</option>
                        <option value="Remote">Remote</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>
                    <div class="invalid-feedback">Please select a job type.</div>
                </div>

                <div class="form-group">
                  <label for="time">Enter job requirements : </label>
                    <textarea name="job-req" id="job-req"  cols="53" rows="4"></textarea>
                </div>
                
              </div>
              <div class="col-lg-5 col-md-6 col-sm-12">
                <div class="form-group">
                  <label > Minimum Salary : </label>
                  <input type="text" class="form-control" id="min-sal" placeholder="salary">
                </div>
                <div class="form-group">
                  <label > Maximum Salary : </label>
                  <input type="text" class="form-control" id="max-sal" placeholder="salary">
                </div>
                
              </div>
            </div>
            <div class="row justify-content-center">
                <input type="submit" value="Post" class="btn btn-primary" id="submit" style="width:200px; border-radius:9px;">
            </div>
            </form>
        </div>
      </div>
    </div>

    <script>
        let form = $("#postJob");
        let submitBtn = $("#submit");

        $(document).ready(function() {
            form.submit(function(e) {
                e.preventDefault()
                form.addClass('was-validated');
                let formData = new FormData(this);

                if (!form[0].checkValidity()) {
                    e.stopPropagation();
                    
                }
                else {
                    $.ajax({
                        url: "/api/employer/postJob.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data.statusCode == 200) {
                                form.removeClass('was-validated');
                                form[0].reset()
                                showAlert(data.data, "success")
                                setTimeout(function() {
                                    window.location.href = "login.php"
                                }, 10000)
                                console.log(data);
                            }
                            else {
                                showAlert(data, "danger")
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            showAlert(errorThrown, "danger");
                            console.log(XMLHttpRequest);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                    })
                }
            })
        })
    </script>

</body>
</html>
