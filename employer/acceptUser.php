<!-- user id -- imp to display details  -->
<?php
    include "../common/connection.php";
    $userId = $_GET['userId'];

    $sql ="UPDATE jobapplication
    SET status = 'Accepted'
    WHERE userId = '".$userId."';";


    if(mysqli_query($conn, $sql))
    {    echo '<script>window.location.href = "dashboard.php"; </script>';
    }
    
?>