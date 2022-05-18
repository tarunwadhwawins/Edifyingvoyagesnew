<?php
require_once('../core/dbconnection.php');
require_once('function.inc.php');
$msg = '';
if (isset($_POST['submit'])) {
  $username = get_safe_value($conn, $_POST['username']);
  $password = get_safe_value($conn, $_POST['password']);
  $sql = "select * from admin where username='$username' and password='$password'";
  $res = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($res);
  if ($count > 0) {
    $_SESSION['ADMIN_LOGIN'] = 'yes';
    $_SESSION['ADMIN_USERNAME'] = $username;
    $_SESSION['success_message'] = "Login successfully.";
   
    header('Location:'. $url."admin/dashboard");
  } else {
    $msg = "Please enter correct login details";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title>
  <link rel="icon" type="image/x-icon" href="../assets/images/favicon.png">
  <link rel="stylesheet" href="../admin/assets/css/style.css">
  <link rel="stylesheet" href="../admin/assets/css/common.css">
</head>

<body>
  <!---->
  <div class="signIn">
    <div class="signInner">
      <div class="wrapper">
        <div class="leftWrapper">
          <img src="../assets/images/logo.png" alt="image" />
        </div>
        <div class="rightWrapper">
          <div class="innerWrapper">
            <h1>Log In</h1>
            <div style="margin-bottom: 15px;font-size: 15px;color: red;"><?php echo $msg ?></div>
            <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
              <div id="successMessage" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
            <?php
              unset($_SESSION['success_message']);
            }
            ?>
            <form class="example-form" method="post">
              <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="username" class="form-control" required />
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="password" class="form-control" required />
              </div>
              <div class="rightCenter mt-30">
                <button type="submit" name="submit" class="btn btn-primary">Login</button>

                <!-- <a href="home" class="btn btn-primary">Login</a> -->
                <a href="javascript:void(0)">Forgot Password</a><br>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!---->
</body>

</html>