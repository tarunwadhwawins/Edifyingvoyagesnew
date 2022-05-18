<?php
require_once('../core/dbconnection.php');
require_once('../core/ajax.php');
$tag =  $msg = '';
if(isset($_GET['id']) && $_GET['id']!='')
{
    $id=get_safe_value($conn,$_GET['id']);
    $res=mysqli_query($conn,"select * from tags where id='$id'");
    $check=mysqli_num_rows($res);
    if($check>0)
    {
        $row=mysqli_fetch_assoc($res);
        $tag=$row['tag'];
    }
    else
    {
        header('location:tags.php');
        die();
    }
    
}

if(isset($_POST['submit']))
{
    $tag=get_safe_value($conn,$_POST['tag']);

    $res=mysqli_query($conn,"select * from tags where tag='$tag'");
    $check=mysqli_num_rows($res);
    if($check>0)
    {
       if(isset($_GET['id']) && $_GET['id']!='')
       {
           $getData=mysqli_fetch_assoc($res);
           if($id==$getData['id'])
           {
           }
           else
           {
            $msg="Name already exist"; 
           }
       }
       else
       {
        $msg="Name already exist"; 
       }
    
    }
    
    if($msg=='')
    {
        if(isset($_GET['id']) && $_GET['id']!='')
        {
            mysqli_query($conn,"update tags set tag='$tag'  where id='$id'"); 
            session_start();
            $_SESSION['success_message'] = "Tags updated successfully.";   
            header('location:add-tag.php');
            die();
        }
        else
        {
            mysqli_query($conn,"insert into tags(tag,status) values('$tag' ,'1')");
        }
        session_start();
        $_SESSION['success_message'] = "Tags inserted successfully.";   
        header('location:add-tag.php');
        die();    
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tags</title>
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
                <h1>Tags</h1>
                <div class="addBtn">
                    <a class="btn btn-primary" href="tags.php">Back</a>
                </div>
            </div>
            <div class="whiteBg">
                <h2>Tags</h2>
                <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
                    <div style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                <?php
                    unset($_SESSION['success_message']);
                }
                ?>
                <form method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="tag" value="<?php echo $tag ?>" class="form-control" placeholder="Enter Name" required />
                            <span><?php echo $msg ?></span>
                        </div>
                    </div>
                  
                    <div class="col-sm-12">
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!---->
    <?php include_once('common/commonjs.php'); ?>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script>
    <!---->
</body>

</html>