<?php
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
    $update_status="update blogs set status='$status' where id='$id'";
    mysqli_query($conn,$update_status);
  }

  if($type=='delete')
  {
    $id=get_safe_value($conn,$_GET['id']); 
    $delete_sql="delete from blogs where id='$id'";
    mysqli_query($conn,$delete_sql);
  }

}
//$sql= "select portfolio.*,category.name from portfolio,category where portfolio.category_id=category.id order by portfolio.id desc";
$sql= "select * from blogs order by id desc";
$res=mysqli_query($conn,$sql);

//pagination...

if (isset($_GET['pageno']))
{
    $pageno = $_GET['pageno'];
}
 else
{
    $pageno = 1;
}
$no_of_records_per_page = 5;
$offset = ($pageno-1) * $no_of_records_per_page;
$total_pages_sql = "SELECT COUNT(*) FROM blogs";
$result = mysqli_query($conn,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);
$sql = "SELECT * FROM blogs order by date desc LIMIT $offset, $no_of_records_per_page ";
$res = mysqli_query($conn,$sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
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
                <h1>Blogs</h1>
                <div class="addBtn">
                    <a class="btn btn-primary" href="add-blog.php">Add Blogs</a>
                </div>
            </div>
            <div class="whiteBg">
                <h2>Blogs Listing</h2>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Sr. No</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Short Description</th>
                                    <th >Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                $i=$offset+1;
                                 while($row=mysqli_fetch_assoc($res)) {?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><img src="../assets/blogimages/<?php echo $row['image'] ?>" width="70px" height="50px" class="img-thumbnail"/> </td>
                                    <?php
                                        $str = $row['short_desc'];
                                        if( strlen( $row['short_desc']) > 100) 
                                        {
                                            $str = explode( "\n", wordwrap( $row['short_desc'], 100));
                                            $str = $str[0] . '';
                                        }
                                    ?>
                                    <td><?php echo $str;  ?></td>
                                    <td class="text-nowrap"><?php echo date("d M , Y", strtotime($row['date'])); ?></td>
                                    <td>
                                    <?php 
                                    if($row['status']==1)
                                    {
                                        echo "<a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a>";
                                        }else{
                                            echo "<a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a>";
                                        }

                                          ?>  
                                    </td>

                                    <td class="text-nowrap">
                                    <?php
                                
                                echo "<a class='btn btn-primary mr-2' href='add-blog.php?id=".$row['id']."' onclick='return confirm_edit();'><i class='fa fa-edit'></i></a>";
                                echo "<a class='btn btn-danger' href='?type=delete&id=".$row['id']."' onclick='return confirm_delete();'><i class='fa fa-close'></i></a>";
                                   ?>
                                    </td>
                                    

                                    <!-- <td><button class="btn btn-primary"><i class="fa fa-edit"></i></button> <button class="btn btn-danger"><i class="fa fa-close"></i></button></td> -->
                                </tr>
                                <?php $i++ ?>
                                <?php } ?>
                               
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