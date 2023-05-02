<?php
    session_start();
    setcookie("page", "users", time() + (86400 * 30), "/");
?>

<nav class="navbar navbar-expand-sm navbar-light bg-primary">
      <div class="container">
        <a class="navbar-brand" href="/we-project/">Job Finder</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/we-project/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/we-project/jobs">Job Search</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <?php 
                            if (!isset($_SESSION['email'])) {
                        ?>
                            <a class="dropdown-item" href="/we-project/login.php">Login</a>
                            <a class="dropdown-item" href="/we-project/signup.php">Sign Up</a>
                        <?php 
                            } 
                            else {
                        ?>
                            <a class="dropdown-item" href="/we-project/users/dashboard.php">Dashboard</a>
                            <a class="dropdown-item" href="/we-project/users/myaccount.php">My Account</a>
                            <a class="dropdown-item" href="/we-project/common/logout.php">Logout</a>
                        <?php 
                            }
                        ?>
                    </div>
                </li>
            </ul>
        </div>
  </div>
</nav>
