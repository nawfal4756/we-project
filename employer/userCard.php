

<?php
    function cardOfUser ( $conn, $userId , $companyId , $jobId  ){

        $sl= "select * from job where id='". $jobId ."';";
        $result=mysqli_query($conn,$sl);
        $row= mysqli_fetch_array($result);
        
        $sl2= "select * from user where id='".$userId."';";
        $result2 = mysqli_query($conn,$sl2);
        $row2 = mysqli_fetch_array($result2);
?>
<style>
    .text-shadow {
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

</style>
<div id="<?php echo $userId; ?>" class="card ml-5 shadow-lg p-3 mb-5 bg-white rounded" style="width:400px; height: 700px;">
  <div class="card-body">
    <img class="card-img-top" src="av.png" alt="Card image" style="width:100%">
    <h1 class="card-title text-shadow"> <?php echo $row2['name']; ?></h1>
    <p class="card-text text-shadow"><b> Job Title : <?php echo $row['title']; ?></b> </p>
    <p class="card-text"> Location : <?php echo $row['location']; ?> </p>
    <p class="card-text"> Job Type : <?php echo $row['type']; ?></p>
    <p class="card-text"> Job Requirements : <?php echo $row['requirements']; ?></p>
    <p class="card-text"><b>Salary :  <?php echo $row['minSalary']; ?> -  <?php echo $row['maxSalary']; ?></b></p>
    <a href="viewdetails.php?userId=<?php echo $userId; ?>" class="btn btn-primary"> View CV </a>
    <a href="acceptUser.php?userId=<?php echo $userId; ?>&companyId=<?php echo $_SESSION['companyId']; ?>&jobId=<?php echo $jobId; ?>" id="accept" class="btn btn-primary"> Accept </a>
  </div>
</div>




<?php
    }
?>


<script>
  
</script>