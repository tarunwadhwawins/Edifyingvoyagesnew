<?php
require_once('../core/dbconnection.php');
require_once('function.inc.php');
$msg = '';
if (isset($_POST['password'])) {
  $password = get_safe_value($conn, $_POST['password']);
  $confirm_password = get_safe_value($conn, $_POST['confirm_password']);
  if($password == $confirm_password){
    $sql = "UPDATE `admin` SET `password`='".$password."' WHERE `username` ='".$_SESSION['ADMIN_USERNAME']."'";
    $res = mysqli_query($conn, $sql);
    $success = "Password update successfully";
  }else{
    $error = "Confirm Password should same as password.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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
                <h1>Change Password</h1>
            </div>
            <div class="whiteBg">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="post" onsubmit="return validation();">
                        <?php if(@$success!=""){ ?>
                                <p class="alert alert-success" id="success"><?php echo @$success; ?></p>
                        <?php } ?>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" placeholder="New password" name="password" id="password"/>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" placeholder="Confirm password" name="confirm_password" id="confirm_password"/>
                            </div>
                            <div class="form-group">
                                <p class="error" id="error"><?php echo @$error; ?></p>
                                <button class="btn btn-primary" type="submit">Save </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---->
    <?php include_once('common/commonjs.php'); ?>
    <!---->
    <script>
        <?php if(@$success!=""){ ?>
            setTimeout(function(){ 
                    $("#success").remove(); 
                    window.location = "<?php echo $url ?>admin/dashboard";
            }, 3000);
        <?php } ?>
        function validation(){
            $("#error").text("");
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();
            if(password == ''){
                $("#error").text("Password is required.");
                return false;
            }
            if(confirm_password == ''){
                 $("#error").text("Confirm Password is required.");
                return false;
            }
            if(confirm_password != password){
                 $("#error").text("Confirm Password should same as password.");
                return false;
            }
        }
    </script>
</body>

</html>