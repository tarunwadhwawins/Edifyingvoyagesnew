<?php
require_once('../core/dbconnection.php');
?>

<header class="header fixed-top">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg">
        <div id="menu" class="icon-sidebar">
          <i class="fa fa-angle-double-left left"></i>
        </div>
        <ul class="navbar-nav ml-auto">
          <li>
            <div class="dropdown">
              <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Hi,
               <?php
                echo $_SESSION['ADMIN_USERNAME'];
               ?>
              </a>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="#">My Profile</a>
                <a class="dropdown-item" href="change-password">Change Password</a>
                <a class="dropdown-item" href="logout.php">Log Out</a>
              </div>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </header>