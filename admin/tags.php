<?php
require_once('../core/dbconnection.php');
require_once('../core/ajax.php');
if(isset($_GET['type']) && $_GET['type']!='')
{
    $type=get_safe_value($conn,$_GET['type']);
    if($type=='status')
  {
    $operation=get_safe_value($conn,$_GET['operation']);
    $id=get_safe_value($conn,$_GET['id']);  

    if($operation=='active')
    {
      $status='1';
    }
    else
    {
     $status='0';
    }
    $update_status="UPDATE tags SET status='$status' WHERE id='$id'";
    mysqli_query($conn,$update_status);
  }

  if($type=='delete')
  {
    $id=get_safe_value($conn,$_GET['id']); 
    $delete_sql="DELETE FROM tags WHERE id='$id'";
    mysqli_query($conn,$delete_sql);
  }

}
//pagination...

if (isset($_GET['pageno']))
{
    $pageno = $_GET['pageno'];
}
 else
{
    $pageno = 1;
}
$no_of_records_per_page = 10;
$offset = ($pageno-1) * $no_of_records_per_page;
$total_pages_sql = "SELECT COUNT(*) FROM tags";
$result = mysqli_query($conn,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);
$sql = "SELECT * FROM tags ORDER BY tag ASC LIMIT $offset, $no_of_records_per_page";
$res = mysqli_query($conn,$sql);
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
                    <a class="btn btn-primary" href="add-tag.php">Add Tags</a>
                </div>
            </div>
            <div class="whiteBg">
                <h2>Tags Listing</h2>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Tag</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                 while($row=mysqli_fetch_assoc($res)) {?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $row['tag'] ?></td>
                                    <td>
                                        <?php 
                                        if($row['status']==1)
                                        {
                                            echo "<a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a>";
                                        }else
                                        {
                                            echo "<a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a>";
                                        }

                                        ?>
                                    </td>
                                <td>
                                      <?php
                                
                                      echo "<a class='btn btn-primary mr-2' href='add-tag.php?id=".$row['id']."'><i class='fa fa-edit'></i></a>";
                                      echo "<a class='btn btn-danger' href='?type=delete&id=".$row['id']."'><i class='fa fa-close'></i></a>";
                                      ?>
                                </td>
                                </tr>
                                <?php $i++ ?>
                                <?php } ?>
                                
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="col-sm-12">
                    <div class="pagintionlisting">
                        <!-- <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul> -->
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
</body>

</html>