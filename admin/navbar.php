<?php
    require "verification.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    setcookie("page", "admin", time() + (86400 * 30), "/");
?>

<nav class="navbar navbar-expand-sm navbar-light bg-primary">
      <div class="container">
        <a class="navbar-brand" href="/admin/dashboard.php">Job Finder Admin</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/admin/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/view.php/?type=company">Company</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/view.php/?type=employers">Employers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/view.php/?type=job">Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/view.php/?type=user">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/view.php/?type=admin">Admins</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="/admin/myaccount.php">My Account</a>
                        <a class="dropdown-item" href="/common/logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
  </div>
</nav>
