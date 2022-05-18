<?php
require_once('../core/dbconnection.php');
require_once('../core/ajax.php');

$category = "";
$tag = "";
$category_id = 0;
$tag_id = "ALL";
if(isset($_GET['category']) && $_GET['category']!='0'){
    $category = " AND portfolio.category_id='".$_GET['category']."'";
    $category_id = $_GET['category'];
}
if(isset($_GET['tag']) && $_GET['tag']!='ALL'){
    $tag = " AND FIND_IN_SET('".$_GET['tag']."',portfolio.tags)";
    $tag_id = $_GET['tag'];
}

if($category_id == 0 && $tag_id == "ALL"){

    $sql = "select portfolio.* from (SELECT portfolio.*,category.name FROM portfolio inner join category on portfolio.category_id=category.id group by portfolio.id) as portfolio LEFT JOIN portfolio_order on portfolio_order.portfolio_id = portfolio.id where portfolio_order.tag_id ='ALL' AND portfolio_order.category_id ='0'   order by portfolio_order.position ASC; ";

}elseif($tag_id != "ALL" && $category_id == 0){
    $sql = "select portfolio.* from (SELECT portfolio.*,category.name FROM portfolio inner join category on portfolio.category_id=category.id WHERE FIND_IN_SET('".$tag_id."',portfolio.tags)) as portfolio LEFT JOIN portfolio_order on portfolio_order.portfolio_id = portfolio.id  AND FIND_IN_SET(portfolio_order.tag_id,portfolio.tags) where  portfolio_order.category_id ='0'  order by portfolio_order.position ASC; ";
}elseif($category_id != 0 && $tag_id == "ALL"){
    $sql = "select portfolio.* from (SELECT portfolio.*,category.name FROM portfolio inner join category on portfolio.category_id=category.id WHERE portfolio.category_id='".$category_id."') as portfolio LEFT JOIN portfolio_order on portfolio_order.portfolio_id = portfolio.id AND portfolio_order.category_id = portfolio.category_id  where portfolio_order.tag_id ='ALL' order by portfolio_order.position ASC; ";
}else{
    $sql = "select portfolio.* from (SELECT portfolio.*,category.name FROM portfolio inner join category on portfolio.category_id=category.id WHERE FIND_IN_SET('".$tag_id."',portfolio.tags) AND portfolio.category_id='".$category_id."') as portfolio LEFT JOIN portfolio_order on portfolio_order.portfolio_id = portfolio.id AND portfolio_order.category_id = portfolio.category_id and FIND_IN_SET(portfolio_order.tag_id,portfolio.tags) order by portfolio_order.position ASC; ";
}

//echo $sql;die;
$res = mysqli_query($conn,$sql);

$sql = "SELECT * FROM category";
$category = mysqli_query($conn,$sql);

$sql = "SELECT * FROM tags order by tag";
$tag = mysqli_query($conn,$sql);
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
                <h2>Portfolio</h2>
                <div class="form-group mb-2">
                    <lable>Category</lable>
                    <select class="form-control" id="category" onchange="load_portfolio();">
                        <option value="0" selected>ALL</option>
                        <?php while($row=mysqli_fetch_assoc($category)) { ?>
                        <option <?php if(@$_GET['category']==$row['id']){ echo "selected"; } ?> value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>

                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <lable>Tags</lable>
                    <select class="form-control" id="tag" onchange="load_portfolio();">
                        <option value="ALL" selected>ALL</option>
                        <?php while($row=mysqli_fetch_assoc($tag)) { ?>

                        <option <?php if(@$_GET['tag']==$row['tag']){ echo "selected"; } ?> value="<?php echo $row['tag'] ?>"><?php echo $row['tag'] ?></option>

                        <?php } ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <ul id="sortable" class="list-group">
                            <?php while($row=mysqli_fetch_assoc($res)) { ?>
                                <li class="ui-state-default list-group-item" id="<?php echo $row['id']; ?>">
                                    <b><?php echo $row['title']; ?></b><br/><?php echo $row['name'] ?><br/> <?php echo $row['tags'] ?>
                                </li>
                            <?php } ?>
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
        
        $(document).ready(function(){
            $( "#sortable" ).sortable({
                update: function( event, ui ) {
                    var task_order = $( "#sortable" ).sortable( "toArray" );
                    var category = $("#category").val();
                    var tag = $("#tag").val();
                    $.ajax({
                        url: "<?php echo $url; ?>core/ajax",
                        type: 'post',
                        data: {"task_order":task_order,'category':category,"tag":tag,'Action':'portfolioOrder'},
                        success: function(data) {
                            console.log("order change");
                        }
                    });
                }
            });
        });
        function load_portfolio() {
            var category = $("#category").val();
            var tag = $("#tag").val();
            var url = '<?php echo $url ?>admin/portfolio-order?category='+category+'&tag='+tag;
            window.location = url;
        }
    </script>
</body>
</html>