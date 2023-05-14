<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

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
    <div>
        <h1 class="text-shadow mt-5 text-center text-white mb-5"><b> Employer Panel</b></h1>
    </div>

    <!-- users which applied  -->
    <?php
        include "userCard.php";
        include "../common/connection.php";
        $sql = "select * from jobapplication;";
        $r=mysqli_query($conn, $sql);

    ?>
    <div class="container-fluid shadow-lg p-3 mb-5 rounded">
        <div class="row">  
        <?php
            while ($row = mysqli_fetch_array($r)){
        ?>
            <div class="col-md-4">
                <?php
                    cardOfUser ($conn , $row['userId'] , $row['comapnyId'] , $row['jobId']  );
                ?>
            </div>
        <?php 
            }     
        ?>
        </div>
       </div> 
    
</body>

<!-- cardOfUser (12 , "FUll Stack WEb Developer" , "sdsa" , "Remote" , "experienced 10x more, qualification woth none other " , 231 , 5869 ); -->
