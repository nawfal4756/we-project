<!-- user id -- imp to display details  -->
<?php
    include "../common/connection.php";
    $userId = $_GET['userId'];
    $companyId = $_GET['companyId'];
    $jobId = $_GET['jobId'];

    $sql ="UPDATE jobapplication
    SET status = 'Accepted'
    WHERE userId = '$userId' AND companyId = '$companyId' AND jobId = '$jobId';";


    if(mysqli_query($conn, $sql))
    {    echo '<script>window.location.href = "dashboard.php"; </script>';
    }
    
?>