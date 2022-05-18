<?php
  require_once('../core/dbconnection.php');
  $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $current_page = str_replace($url."admin/", "", $current_url); 
  if($_SESSION['ADMIN_LOGIN'] != "yes") {
    header("Location: http://localhost/Dits-Website/admin/");
  }
?>

<div class="sidebar-offcanvas">
  <a class="navbar-brand mb-2 px-2" href="#">
    <img src="<?php echo $url; ?>admin/assets/images/logo.png" alt="image">
  </a>
  <div class="sidebar-menu">
    <ul class="nav flex-column">
      <li class="nav-item <?php echo $current_page == 'dashboard' ? 'active':'' ?>">
        <a class="nav-link" href="<?php echo $url; ?>admin/dashboard">
          <i class="fa fa-tachometer"></i>
          <div class="text">Dashboard</div>
        </a>
      </li>
      <li class="nav-item <?php echo $current_page == 'metatags' ? 'active':'' ?>">
        <a class="nav-link" href="<?php echo $url; ?>admin/metatags">
          <i class="fa fa-file"></i>
          <div class="text">Meta Tags</div>
        </a>
      </li>
       <li class="nav-item sub-menu <?php echo $current_page == 'portfolio' ? 'active':'' ?>">
          <a class="nav-link" href=javascript:void(0)">
          <i class="fa fa-tty"></i>
            <div class="text">Portfolio</div>
            <span class="right"><i class="fa fa-angle-down"></i></span>
          </a>
          <ul class="innerMenus">
              <li><a href="<?php echo $url; ?>admin/portfolio">Portfolio Listing</a></li>
              <li><a href="<?php echo $url; ?>admin/category">Category</a></li>
              <li><a href="<?php echo $url; ?>admin/tags">Tags</a></li>
              <li><a href="<?php echo $url; ?>admin/portfolio-order">Ordering</a></li>
          </ul>
      </li>
      <li class="nav-item <?php echo $current_page == 'blogs' ? 'active':'' ?>">
        <a class="nav-link" href="<?php echo $url; ?>admin/blogs">
          <i class="fa fa-file"></i>
          <div class="text">Blogs</div>
        </a>
      </li>
      <li class="nav-item <?php echo $current_page == 'contact' ? 'active':'' ?>">
        <a class="nav-link" href="<?php echo $url; ?>admin/contact">
          <i class="fa fa-file"></i>
          <div class="text">Contact</div>
        </a>
      </li>
    </ul>
  </div>
</div>