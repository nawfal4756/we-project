<!-- user id -- imp to display details  -->
<?php
    include "../common/connection.php";
    $userId = $_GET['userId'];

    $sql ="SELECT * from user where id='".$userId."';";
    $result= mysqli_query($conn, $sql);
    $userDetails = mysqli_fetch_array($result);

    $sql2 = "select * from usereducation where userId='" .$userId."';";
    $result2 = mysqli_query($conn, $sql2);
    $userEd = mysqli_fetch_array($result2);

    $sql3= "SELECT *
    FROM userskills
    JOIN skills
    ON userskills.skillId = skills.id where userId='".$userId."';";

    $result3 = mysqli_query($conn, $sql3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link href="../styles/styles.css" rel="stylesheet">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="bg-secondary">
    <!-- navbar -->
    <div>
        <?php require "navbar.php" ?>;
    </div>

    <!-- info  -->
    <div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="av.png"><span class="font-weight-bold"><?php echo $userDetails['name']; ?></span><span class="text-black-50"><?php echo $userDetails['email']; ?></span><span> </span>
                <div class="row mt-5">
                    <?php
                        while ( $row = mysqli_fetch_array($result3)){
                    ?>
                    <div class="col-md-4 mt-2 ">
                        <button class="btn-btn-primary"> <?php echo $row['name']; ?></button>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">User Profile </h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6"><label class="labels">Name</label><input type="text" disabled  class="form-control" value="<?php echo $userDetails['name']; ?>" value=""></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Email</label><input type="text" disabled  class="form-control"  value="<?php echo $userDetails['email']; ?>"></div>
                    <div class="col-md-12"><label class="labels">Phone</label><input type="text" disabled  class="form-control"  value="<?php echo $userDetails['phone']; ?>"></div>
                    <div class="col-md-12"><label class="labels">Gender</label><input type="text" disabled  class="form-control"  value="<?php echo $userDetails['gender']; ?>"></div>
                    <div class="col-md-12"><label class="labels">Date Of Birth </label><input type="text" disabled  class="form-control"  value="<?php echo $userDetails['dob']; ?>"></div>
                    <div class="col-md-12"><label class="labels">Specialization </label><input type="text" disabled  class="form-control"  value="<?php echo $userDetails['specialization']; ?>"></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6"><label class="labels">Country</label><input type="text" disabled  class="form-control"  value="Pakistan"></div>
                    <div class="col-md-6"><label class="labels">State/Region</label><input type="text" disabled  class="form-control" value="Asia" ></div>
                </div>
                <div class="mt-5 text-center"><a href="dashboard.php" class="btn btn-primary profile-button" type="button"> Go Back </a></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center experience"><span></span><span class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;User Education </span></div><br>
                <div class="col-md-12"><label class="labels">Major </label><input type="text" disabled  class="form-control"  value="<?php echo $userEd['field']; ?>"></div> <br>
                <div class="col-md-12"><label class="labels"> Institute Name</label><input type="text" disabled  class="form-control"  value="<?php echo $userEd['instituteName']; ?>"></div>
                <div class="col-md-12"><label class="labels">CGPA  </label><input type="text" disabled  class="form-control"  value="<?php echo $userEd['cgpa']; ?>"></div> <br>
                <div class="col-md-12"><label class="labels"> Graduation Year </label><input type="text" disabled  class="form-control"  value="<?php echo $userEd['endYear']; ?>"></div>
            
            </div>
        </div>
    </div>
</div>
</div>
</div>
</body>



