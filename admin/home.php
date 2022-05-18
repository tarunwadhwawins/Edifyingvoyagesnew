<?php
require_once('../core/dbconnection.php');
require_once('function.inc.php');
 if(isset( $_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){

 }else{
   header('location:index.php');
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!---->
    <?php include_once('common/commoncss.php'); ?>
    <!---->
</head>
<body>
  <!--sidebar-->
  <?php include_once('common/sidebar.php'); ?>
  <!--header-->
  <?php include_once('common/header.php'); ?>
  <!--content-->
  <div class="main-content">
    <div class="inner-content">
      <div class="heading">
        <h1>Dashboard</h1>
      </div>
    </div>
  </div>
  <!---->
  <?php include_once('common/commonjs.php'); ?>
  <!---->
</body>
</html>   