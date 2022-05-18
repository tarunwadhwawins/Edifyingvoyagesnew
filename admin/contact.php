<?php
require_once('../core/ajax.php');
    $sql= "select * from contacts order by ContactId desc";
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
    $total_pages_sql = "SELECT COUNT(*) FROM contacts";
    $result = mysqli_query($conn,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    $sql = "SELECT * FROM contacts order by ContactId desc LIMIT $offset, $no_of_records_per_page ";
    $res = mysqli_query($conn,$sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
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
                <h1>Contact</h1>
            </div>
            <div class="whiteBg">
                <h2>Contact Listing</h2>
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>

                                        <th class="text-nowrap">Sr. No</th>
                                        <th class="text-nowrap">Ip Address</th>
                                        <th>URL</th>
                                        <th>Name</th>
                                        <th>Email Id</th>
                                        <th>Country </th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Phone No.</th>
                                        <th>Find Us</th>
                                        <!-- <th>Message</th> -->
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=$offset+1;
                                        while($row=mysqli_fetch_assoc($res)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['IP']; ?></td>
                                                <td><?php echo $row['URL']; ?></td>
                                                <td><?php echo $row['FirstName']; ?></td>
                                                <td><?php echo $row['Email']; ?></td>
                                                <td><?php echo $row['Country']; ?></td>
                                                <td><?php echo $row['State']; ?></td>
                                                <td><?php echo $row['City']; ?></td>
                                                <td><?php echo $row['Phone']; ?></td>
                                                <td><?php echo $row['FindUs']; ?></td>
                                                <!-- <td><?php echo $row['Message']; ?></td> -->
                                                <td class="text-nowrap">
                                                    <a class="btn btn-primary mr-2 " onclick="contact_detail(this);" data-load='<?php echo str_replace("'", "",  json_encode($row)); ?>'><i class="fa fa-eye"></i></a>
                                                                            
                                                </td>
                                            </tr>
                                    <?php 
                                            $i++ ;
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
        <script>
            function contact_detail(ele){
                var data = $(ele).data('load');
                console.log(data);
                $("#name").text(data.FirstName);
                $("#email").text(data.Email);
                $("#ip").text(data.IP);
                $("#url").text(data.URL);
                $("#county").text(data.Country);
                $("#state").text(data.State);
                $("#city").text(data.City);
                $("#phone").text(data.Phone);
                $("#find_us").text(data.FindUs);
                $("#message").text(data.Message);

                $("#contact_detail").modal("show");
            }
        </script>
        <!---->
</body>

</html>


<div class="modal" id="contact_detail">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Name</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">Ip Address</div>
            <div class="col-sm-6" id="ip">...</div>
            <div class="col-sm-6">URL</div>
            <div class="col-sm-6" id="url">...</div>
            <div class="col-sm-6">Name</div>
            <div class="col-sm-6" id="name">...</div>
            <div class="col-sm-6">Email</div>
            <div class="col-sm-6" id="email">...</div>
            <div class="col-sm-6">Country</div>
            <div class="col-sm-6" id="county">...</div>
            <div class="col-sm-6">State</div>
            <div class="col-sm-6" id="state">...</div>
            <div class="col-sm-6">City</div>
            <div class="col-sm-6" id="city">...</div>
            <div class="col-sm-6">Phone No</div>
            <div class="col-sm-6" id="phone">...</div>
            <div class="col-sm-6">Find Us</div>
            <div class="col-sm-6" id="find_us">...</div>
            <div class="col-sm-12">Message</div>
            <div class="col-sm-12" id="message">...</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>