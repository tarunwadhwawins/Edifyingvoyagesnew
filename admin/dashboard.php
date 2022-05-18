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
            <div class="whiteBg">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card blogCard">
                            <div class="card-header">Blogs</div>
                            <div class="card-body">
                                 <?php
                                    $sql= "SELECT * FROM blogs WHERE status=1 ORDER BY date desc";
                                    $res=mysqli_query($conn,$sql);
                                  ?>
                                <div class="value"><?php echo $res->num_rows; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="card blogCard">
                            <div class="card-header">Portfolios</div>
                            <div class="card-body">
                                <div class="portValues">
                                    <?php
                                        $sql= "SELECT * FROM category  where status=1";
                                        $res= mysqli_query($conn,$sql);
                                        $data=array();
                                        while($row= mysqli_fetch_assoc($res)){
                                            $sql = "SELECT portfolio.* FROM portfolio WHERE category_id='".$row['id']."' ";
                                            $portfolio= mysqli_query($conn,$sql);
                                    ?>
                                            <div class="portValue"><?php echo $row['name']; ?>
                                                <span class="numeric"><?php  echo $portfolio->num_rows; ?></span>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
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