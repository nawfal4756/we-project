<?php
    if (session_status()=== PHP_SESSION_NONE )
    {
        session_start();
    }
    
    $employerId = $_SESSION['employerId'] ;
    include "../common/connection.php";

    $sql= "SELECT company.name , company.location
    FROM employer
    JOIN company
    ON employer.companyid = company.id
    where employer.id ='".$employerId."';";

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

    <!-- company Details -->
    <section class="vh-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-12 col-xl-4">

            <div class="card" style="border-radius: 15px;">
            <div class="card-body text-center">
                <div class="mt-3 mb-4">
                <img src=""
                    class="rounded-circle img-fluid" style="width: 100px;" />
                </div>
                <h4 class="mb-2"><?php $row['name'] ?></h4>
                <p class="text-muted mb-4"> <?php $row['location'] ?></p>
                <div class="mb-4 pb-2">
                <button type="button" class="btn btn-outline-primary btn-floating">
                    <i class="fab fa-facebook-f fa-lg"></i>
                </button>
                <button type="button" class="btn btn-outline-primary btn-floating">
                    <i class="fab fa-twitter fa-lg"></i>
                </button>
                <button type="button" class="btn btn-outline-primary btn-floating">
                    <i class="fab fa-skype fa-lg"></i>
                </button>
                </div>
                <button type="button" class="btn btn-primary btn-rounded btn-lg">
                Message now
                </button>
                <div class="d-flex justify-content-between text-center mt-5 mb-2">
                <div>
                    <p class="mb-2 h5">8471</p>
                    <p class="text-muted mb-0">Wallets Balance</p>
                </div>
                <div class="px-3">
                    <p class="mb-2 h5">8512</p>
                    <p class="text-muted mb-0">Income amounts</p>
                </div>
                <div>
                    <p class="mb-2 h5">4751</p>
                    <p class="text-muted mb-0">Total Transactions</p>
                </div>
                </div>
            </div>
            </div>

        </div>
        </div>
    </div>
    </section>

</body>
</html>