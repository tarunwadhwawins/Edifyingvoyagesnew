<?php
require_once('../core/dbconnection.php');
require_once('../core/ajax.php');
$name = $slug = $msg = '';
if(isset($_GET['id']) && $_GET['id']!='')
{
    $id=get_safe_value($conn,$_GET['id']);
    $res=mysqli_query($conn,"select * from category where id='$id'");
    $check=mysqli_num_rows($res);
    if($check>0)
    {
        $row=mysqli_fetch_assoc($res);
        $name=$row['name'];
        $slug=$row['slug']; 
    }
    else
    {
        header('location:category.php');
        die();
    }
    
}

if(isset($_POST['submit']))
{
    $name=get_safe_value($conn,$_POST['name']);
    $slug=get_safe_value($conn,$_POST['slug']);

    $res=mysqli_query($conn,"select * from category where slug='$slug'");
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
            $msg="Slug already exist"; 
           }
       }
       else
       {
        $msg="Slug already exist"; 
       }
    
    }
    
    if($msg=='')
    {
        if(isset($_GET['id']) && $_GET['id']!='')
        {
            mysqli_query($conn,"update category set name='$name' , slug='$slug' where id='$id'"); 
            session_start();
            $_SESSION['success_message'] = "Category updated successfully.";   
            header('location:add-category.php');
            die();
        }
        else
        {
            mysqli_query($conn,"insert into category(name,slug,status) values('$name','$slug','1')");
        }
        session_start();
        $_SESSION['success_message'] = "Category inserted successfully.";   
        header('location:add-category.php');
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
    <title>Category</title>
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
                <h1>Category</h1>
                <div class="addBtn">
                    <a class="btn btn-primary" href="category.php">Back</a>
                </div>
            </div>
            <div class="whiteBg">
                <h2>Category</h2>
                <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
                    <div style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                <?php
                    unset($_SESSION['success_message']);
                }
                ?>
                <form method="post">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="<?php echo $name ?>" class="form-control" placeholder="Enter Name" required />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" value="<?php echo $slug ?>" class="form-control" placeholder="Enter Slug" required />
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