<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    setcookie("page", "employer", time() + (86400 * 30), "/");
?>

<nav class="navbar navbar-expand-sm navbar-light bg-primary">
      <div class="container">
        <a class="navbar-brand" href="/">Job Finder</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"> Dashboard </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="companyDetails.php"> Company Details </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="employerDetails.php"> Employer Details </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="postJob.php"> Post a Job </a>
                </li>

                <!-- add team members -->

                <li class="nav-item ml-auto ">
                    <a class="nav-link float-right" href="/common/logout.php"> Log Out </a>
                </li>
            </ul>
        </div>
  </div>
</nav>
