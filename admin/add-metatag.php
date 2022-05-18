<?php
require_once('../core/ajax.php');

if (isset($_GET['id']) && $_GET['id'] != '') {
    
    $id = get_safe_value($conn, $_GET['id']);
    $res = mysqli_query($conn, "select * from meta_tags where id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $keyword = $row['keyword'];
        $description = $row['description'];
        $name = $row['page'];
        $slug = $row['slug'];
       
    } else {
        header('location:'.$url."/admin/metatags");
        die();
    }
}
if (isset($_POST['submit'])) {
    
    $title = get_safe_value($conn, $_POST['title']);
    $keyword = get_safe_value($conn, $_POST['keyword']);
    $description = get_safe_value($conn, $_POST['description']);
    $slug = get_safe_value($conn, $_POST['slug']);
    $name = get_safe_value($conn, $_POST['name']);
    
    if (isset($_GET['id']) && $_GET['id'] != '') {
        
        $update_sql = "UPDATE `meta_tags` SET `page`='".$name."',`slug`='".$slug."',`title`='".$title."',`keyword`='".$keyword."',`description`='".$description."' WHERE  id='".$id."'";
       
        mysqli_query($conn, $update_sql);
        $id = $_GET['id'];
        session_start();
        $_SESSION['success_message'] = "Data updated successfully.";
    } else {
        mysqli_query($conn, "INSERT INTO `meta_tags`(`page`, `slug`, `title`, `keyword`, `description`) VALUES ('".$name."','".$slug."','".$title."','".$keyword."','".$description."')");
        $id = mysqli_insert_id($conn);
        session_start();
        $_SESSION['success_message'] = "Data inserted successfully.";
    }

    header('location:add-metatag.php?id=' . $id);
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Meta Tags</title>
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
                <h1>Meta Tags</h1>
                <div class="addBtn">
                    <a class="btn btn-primary" href="metatags">Back</a>
                </div>
            </div>
            <div class="whiteBg">
                <h2>Meta Tags</h2>
                <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
                    <div id="successMessage" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                <?php
                    unset($_SESSION['success_message']);
                }
                ?>
                <!-- <div class="row"> -->
                    <form method="post" action="" class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Page Name</label>
                                <input type="text" name="name" value="<?php echo @$name; ?>" class="form-control" placeholder="Enter page name" data-validation="required" <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Page Slug</label>
                                <input type="text" name="slug" value="<?php echo @$slug; ?>" class="form-control" placeholder="Enter page slug" data-validation="required <?php if(empty($_GET['id'])){ ?> server <?php } ?>" data-validation-url="<?php echo $url; ?>admin/metatags"  <?php if(!empty($_GET['id'])){ echo "readonly"; } ?>/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Seo Title</label>
                                <input type="text" name="title" value="<?php echo @$title; ?>" class="form-control" placeholder="Enter Seo Title" data-validation="required" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Seo Keyword</label>
                                <input type="text" name="keyword" value="<?php echo @$keyword; ?>" class="form-control" placeholder="Enter Seo Keyword" data-validation="required" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Seo Description</label>
                                <textarea class="form-control" name="description" placeholder="Enter Seo Description" data-validation="required"><?php echo @$description; ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
              <!--   </div> -->
            </div>
        </div>
    </div>
     <?php include_once('common/commonjs.php'); ?>
</body>

</html>