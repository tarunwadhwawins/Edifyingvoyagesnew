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
    }else
    {
     $status='0';
    }
    $update_status="UPDATE portfolio SET status='$status' WHERE id='$id'";
    mysqli_query($conn,$update_status);
  }

  if($type=='delete')
  {
    $id=get_safe_value($conn,$_GET['id']); 
    $delete_sql="DELETE FROM portfolio WHERE id='$id'";
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
$PerPAge = 10;
$offset = ($pageno-1) * $PerPAge;

$category_condition = "";

if(isset($_GET['category']) && $_GET['category']!=0){
    $category_condition = " AND portfolio.category_id='".$_GET['category']."'";
}

$total_pages_sql = "SELECT COUNT(*) FROM portfolio, category WHERE portfolio.category_id=category.id ".$category_condition;
$result = mysqli_query($conn,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $PerPAge);
$sql = "SELECT portfolio.*,category.name FROM portfolio,category WHERE portfolio.category_id=category.id ".$category_condition." ORDER BY portfolio.id DESC LIMIT $offset, $PerPAge";
$res = mysqli_query($conn,$sql);

$sql = "SELECT * FROM category";
$category = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
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
                <h1>Portfolio</h1>
                <div class="addBtn">
                    <a class="btn btn-primary" href="add-portfolio.php">Add Portfolio</a>
                </div>
            </div>
            <div class="whiteBg">
                <h2>Portfolio Listing</h2>
                <div class="form-group mb-2">
                    <select class="form-control" id="category" onchange="load_portfolio();">
                       <option value="0" selected>ALL</option>
                        <?php while($row=mysqli_fetch_assoc($category)) { ?>
                        <option <?php if(@$_GET['category']==$row['id']){ echo "selected"; } ?> value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>

                        <?php } ?>
                    </select>
                </div>
             <div class="row">
                 <div class="col-sm-12">
                    <div class="table-responsive">
                         <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Sr. No</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Tags</th>
                                    <th>Title</th>
                                    <!-- <th>Description</th> -->
                                    <th>Date</th>
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
                                    <td><img src="../assets/portfolioimage/<?php echo $row['image'] ?>" width="100px"  class="img-thumbnail"/> </td> 
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['tags'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <!-- <td><?php echo $row['short_desc'] ?> </td> -->
                                    <td class="text-nowrap"><?php echo date("d M , Y", strtotime($row['date'])); ?></td>
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
                                    <td class="text-nowrap">
                                    <?php
                                
                                    echo "<a class='btn btn-primary mr-2' href='add-portfolio.php?id=".$row['id']."' onclick='return confirm_edit();'><i class='fa fa-edit'></i></a>";
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
        function load_portfolio() {
            var category = $("#category").val();
            var url = '<?php echo $url ?>admin/portfolio?category='+category;
            window.location = url;
        }
</script>
</body>
</html>