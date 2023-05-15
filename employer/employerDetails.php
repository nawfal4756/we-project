<?php
    if (session_status()=== PHP_SESSION_NONE )
    {
        session_start();
    }
    
    $employerId = $_SESSION['employerId'] ;
    echo '<script> console.log(" Employer id ");</script>';
    echo "<script> console.log('" . $employerId."');</script>";
    include "../common/connection.php";

    $sql= "SELECT *
    FROM employer
    where id ='".$employerId."';";

    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link href="../styles/styles.css" rel="stylesheet">
    <link href="../styles/companyDetail.css" rel="stylesheet">
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

    <!-- employer Details -->
    <div class="container pt-5">
    <div class="row justify-content-center">
        <div class="card">
            <div class="top-design"></div>
            <div class="card-body"> <img src="empAv.jpeg" alt="" class="avatar">
                <div class="user-info">
                    <h2 class="text-shadow"> <?php echo $row['name']; ?> </h2> <span class="text-muted"> <?php echo $row['email']; ?><br></span><span class="text-muted"> <?php echo $row['phone']; ?></span>
                </div>
                <div class="bg-t">
                    <ul class="nav text-center">
                        <li class="nav-item h4"><a href="#" class="nav-link text-dark"><i class="fa fa-rss "></i> Follow me</a></li>
                    </ul>
                </div>
                <div class="input-group mb-3 w-75 mx-auto"> <a href="dashboard.php" class="btn addBtn form-control" aria-describedby="myBtn"> Go Back </a> </div>
                <div class="bg-b"></div>
            </div>
            <div class="bottom-design"></div>
        </div>
    </div>
    </div>
    <!--  -->

</body>
</html>