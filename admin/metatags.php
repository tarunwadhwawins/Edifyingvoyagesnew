<?php
    require_once('../core/ajax.php');

    
    if(isset($_GET['type']) && $_GET['type']!=''){
        $type=get_safe_value($conn,$_GET['type']);
        if($type=='delete'){
            $id=get_safe_value($conn,$_GET['id']); 
            $delete_sql="DELETE FROM meta_tags WHERE id='$id'";
            mysqli_query($conn,$delete_sql);
        }

    }
    if(isset($_POST['slug']) && $_POST['slug']!=''){
        $slug=get_safe_value($conn,$_POST['slug']);
        if(!isset($_POST['id'])){
           $res = mysqli_query($conn, "select * from meta_tags where slug='$slug'");
            $check = mysqli_num_rows($res);
        }else{
            $id=get_safe_value($conn,$_POST['id']);
            $res = mysqli_query($conn, "select * from meta_tags where id!='$id' and slug='$slug'");
            $check = mysqli_num_rows($res);
        }
        if($check > 0){
            $data = array(
                            "valid" => false,
                            "message" => "Slug already exist",
            );
        }else{
            $data = array(
                            "valid" => true,
                            "message" => "Slug not exist",
            );
        }
        echo json_encode($data);
        die;

    }
    $res = mysqli_query($conn, "select * from meta_tags");
    if (isset($_GET['pageno']))
    {
        $pageno = $_GET['pageno'];
    }
    else
    {
        $pageno = 1;
    }
    $PerPAge = 10;
    $offset = ($pageno-1) * $PerPAge;
    $total_pages_sql = "SELECT COUNT(*) FROM meta_tags";
    $result = mysqli_query($conn,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $PerPAge);
    $sql = "SELECT * FROM meta_tags ORDER BY id DESC LIMIT $offset, $PerPAge";
    $res = mysqli_query($conn,$sql);
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meta Tags</title>
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
                    <a class="btn btn-primary" href="add-metatag.php">Add Meta Tags</a>
                </div>
            </div>
            <div class="whiteBg">
                <h2>Meta Tags Listing</h2>
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap">Sr. No</th>
                                        <th>Url</th>
                                        <th>Page Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $index = $offset+1;
                                    while($row = mysqli_fetch_assoc($res)){
                                ?>
                                    <tr>
                                        <td><?php echo $index; ?></td>
                                        <td><?php echo $row['slug']; ?></td>
                                        <td><?php echo $row['page']; ?></td>
                                        <td class="text-nowrap">
                                            <a class="btn btn-primary mr-2" href="<?php echo $url; ?>admin/add-metatag?id=<?php echo $row['id']; ?>" onclick='return confirm_edit();'><i class="fa fa-edit"></i></a>
                                            <a class="btn btn-danger" href='?type=delete&id=<?php echo $row["id"]; ?>' onclick='return confirm_delete();'><i class="fa fa-close"></i></a>                                
                                        </td>
                                    </tr>
                                <?php
                                        $index++;
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="pagintionlisting">
                            <ul class="pagination">
                                <?php pagination($total_pages,$pageno); ?>
                            </ul>
                        </div>
                    </div> 
                </div>

            </div>
        </div>
        <!---->
    <?php include_once('common/commonjs.php'); ?>
    <!---->

    <script>
        function confirm_delete()
        {
         return confirm("Are you sure want to delete ?");
        }
     
        function confirm_edit()
        {
         return confirm("Are you sure want to edit ?");
        }
    
</script>
</body>

</html>