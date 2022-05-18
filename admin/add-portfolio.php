<?php
require_once('../core/ajax.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$category_id = $seo_title = $seo_keyword = $seo_desc = $title = $slug = $date = $tags = $image = $slider_image = $banner_heading =  $short_desc = $long_desc = $fs_heading = $fs_sub_heading = $fs_description = $fs_image = $image_text = $ss_description = $ss_image = $cat_link =  $msg = $extension = '';
$tags = array();
$image_required = 'required';
$fs_image_required = 'required';
$ss_image_required = 'required';
$sliderImage_required = 'required';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $fs_image_required = '';
    $ss_image_required = '';
    $sliderImage_required = '';
    $id = get_safe_value($conn, $_GET['id']);
    $res = mysqli_query($conn, "select * from portfolio where id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $category_id = $row['category_id'];
        $seo_title = $row['seo_title'];
        $seo_keyword = $row['seo_keyword'];
        $seo_desc = $row['seo_desc'];
        $title = $row['title'];
        $slug = $row['slug'];
        $tags = (explode(',', $row['tags']));
        $image = $row['image'];
        if(!empty($row['slider_image'])){
            $slider_image = (explode(',', $row['slider_image']));
        }else{
            $slider_image = array();            
        }
        $banner_heading = $row['banner_heading'];
        $fs_heading = $row['fs_heading'];
        $fs_sub_heading = $row['fs_sub_heading'];
        $fs_description = $row['fs_description'];
        if(!empty($row['fs_image'])){
            $fs_image = (explode(',', $row['fs_image']));
        }else{
            $fs_image = array();            
        }
        $image_text = $row['image_text'];
        $ss_description = $row['ss_description'];
        if(!empty($row['ss_image'])){
            $ss_image = (explode(',', $row['ss_image']));

        }else{
            $ss_image = array();            
        }
        $date = $row['date'];
        $short_desc = $row['short_desc'];
    } else {
        header('location:portfolio.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    // echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // die;
    
    $category_id = get_safe_value($conn, $_POST['category_id']);
    $title = get_safe_value($conn, $_POST['title']);
    $tags = (implode(',', @$_POST['tags']));
    $banner_heading = get_safe_value($conn, $_POST['banner_heading']);
    $fs_heading = get_safe_value($conn, $_POST['fs_heading']);
    $fs_sub_heading = get_safe_value($conn, $_POST['fs_sub_heading']);
    $fs_description = get_safe_value($conn, $_POST['fs_description']);
    $image_text = get_safe_value($conn, $_POST['image_text']);
    $ss_description = get_safe_value($conn, $_POST['editor1']);
    $date = get_safe_value($conn, $_POST['date']);
    $short_desc = get_safe_value($conn, $_POST['short_desc']);
    $slug1 = str_replace(' ', '-', $title);
    $slug = trim(strtolower($slug1), "?");
    
    $MainImageQuery = ", image = '".trim($_POST['image'],',')."' ";
    $image = trim($_POST['image'],',');


    $Section1ImageQuery = ", fs_image = '".trim($_POST['fs_image'],',')."' ";
    $fsImage = trim($_POST['fs_image'],',');


    $Section2ImageQuery = ", ss_image = '".trim($_POST['ss_image'],',')."' ";
    $ssImage = trim($_POST['ss_image'],',');

    $sliderImageUpdate = ", slider_image = '".trim($_POST['sliderImage'],',')."' ";
    $fileName = trim($_POST['sliderImage'],',');


    $res = mysqli_query($conn, "select * from portfolio where title='$title'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
            } else {
                $msg = "Title already exist";
            }
        } else {
            $msg = "Title already exist";
        }
    }
   
    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            if ($MainImageQuery != '' || $Section1ImageQuery != '' || $Section2ImageQuery != '' || $sliderImageUpdate != '') {
                $update_sql = "update portfolio set  
                category_id = '$category_id' , title='$title', slug='$slug' , tags = '$tags', banner_heading='$banner_heading', 
                fs_heading = '$fs_heading' , fs_sub_heading = '$fs_sub_heading', fs_description = '$fs_description' $Section1ImageQuery , image_text = '$image_text' , ss_description = '$ss_description' $Section2ImageQuery  , date='$date' ,
                short_desc='$short_desc' $MainImageQuery $sliderImageUpdate  where id='$id'";
            } else {
                $update_sql = "update portfolio set  
                category_id = '$category_id' , title='$title', slug='$slug' , tags = '$tags', banner_heading='$banner_heading', fs_heading = '$fs_heading' ,
                fs_sub_heading = '$fs_sub_heading', fs_description = '$fs_description', image_text = '$image_text'  , ss_description = '$ss_description'  , date='$date' ,
                short_desc='$short_desc'  where id='$id'";
            }

            mysqli_query($conn, $update_sql);
            $id = $_GET['id'];
            session_start();
            $_SESSION['success_message'] = "Data updated successfully.";
            header('location:add-portfolio.php?id=' . $id);
        } else {
            mysqli_query($conn, "insert into portfolio (category_id, title, slug , tags, banner_heading , sub_heading , short_desc, fs_heading , fs_sub_heading ,  fs_description ,  fs_image , image_text , ss_description ,  ss_image , date, status, image,slider_image) 
            values( '$category_id', '$title', '$slug' , '$tags', '$banner_heading', '', '$short_desc', '$fs_heading', '$fs_sub_heading' , '$fs_description'  , '$fsImage', '$image_text' , '$ss_description' , '$ssImage' , '$date', '1', '$image',  '$fileName')");
            $id = $conn->insert_id;
            session_start();
            $_SESSION['success_message'] = "Data inserted successfully.";
            header('location:add-portfolio.php');
        }

        
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
    <title>Portfolio</title>
    <!---->
    <?php include_once('common/commoncss.php'); ?>
    <link rel="stylesheet" href="https://unpkg.com/@jcubic/tagger@0.x.x/tagger.css" />
    <!---->
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link
      rel="stylesheet"
      href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
      type="text/css"
    />

    <style>
        .imgGallery img {
            padding: 4px;
            max-width: 100px;
        }

        .ssGallery img {
            padding: 4px;
            max-width: 100px;
        }

        .fsGallery img {
            padding: 4px;
            max-width: 100px;
        }
    </style>
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
                    <a class="btn btn-primary" href="portfolio.php">Back</a>
                </div>
            </div>
            <div class="whiteBg">
                <h2>Portfolio</h2>
                <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
                    <div id="successMessage" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                <?php
                    unset($_SESSION['success_message']);
                }
                ?>
                <form method="post" name="portfolioForm" enctype="multipart/form-data">
                   

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Select Category</label>
                                <select class="form-control" name="category_id" id="category_id" required>
                                    <?php
                                    $res = mysqli_query($conn, "select id,name from category order by name asc");
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        if ($row['id'] == $category_id) {
                                            echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        } else {
                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Select tags</label>
                                <select id="example-getting-started" name="tags[]" multiple="multiple" class="form-control">
                                    <?php

                                    $res = mysqli_query($conn, "select id,tag from tags order by tag asc");
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        if (in_array($row['tag'], $tags)) {
                                            echo "<option selected value='" . $row['tag'] . "'>" . $row['tag'] . "</option>";
                                        } else {
                                            echo "<option value='" . $row['tag'] . "'>" . $row['tag'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" id="title" value="<?php echo $title ?>" class="form-control" placeholder="Enter  Title" required />
                                <span><?php echo $msg ?></span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date</label>
                                <?php
                                if ($date != '') {
                                    $val = date('Y-m-d', strtotime($date));
                                } else {
                                    $val = '';
                                }
                                ?>
                                <input type="date" name="date" id="date" value="<?php echo $val ?>" class="form-control" placeholder="Enter Date" required />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea class="form-control" name="short_desc" id="short_desc" placeholder="Enter Short Description" required><?php echo $short_desc ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Banner Heading</label>
                                <input type="text" name="banner_heading" id="heading" value="<?php echo html_entity_decode($banner_heading); ?>" class="form-control" placeholder="Enter Heading" required />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Images Upload</label>
                                <div class="dropzone" id="myDropzone"></div>
                                <input type="hidden" name="image" value="<?php echo @$image; ?>" id="mainImage" />
                               
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">First Section</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Heading</label>
                                                <input type="text" name="fs_heading" id="fs_heading" value="<?php echo $fs_heading ?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Sub-Heading</label>
                                                <textarea class="form-control" name="fs_sub_heading" id="fs_sub_heading"><?php echo $fs_sub_heading ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="fs_description" id="fs_description" required><?php echo $fs_description ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Image Upload</label>
                                                <div class="fsGallery"></div>
                                                
                                                <div class="dropzone" id="fsimageDropzone"></div>
                                                <?php if(!empty($fs_image)){ ?> 
                                                        <input type="hidden" name="fs_image" value="<?php echo implode(',',@$fs_image); ?>" id="fs_image" />

                                                <?php }else{ ?> 
                                                        <input type="hidden" name="fs_image" value="" id="fs_image" />

                                                <?php } ?>
                                                
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Image Map</label>
                                                <textarea class="form-control" name="image_text" id="image_text"><?php echo $image_text ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">Second Section</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea  name="editor1" id="editor1" required><?php echo $ss_description ?></textarea>
                                            </div>
                                            </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Image Upload</label>
                                                <div class="ssGallery"></div>
                                                
                                                <div class="dropzone" id="ssimageDropzone"></div>
                                                
                                                <?php if(!empty($ss_image)){ ?> 
                                                        <input type="hidden" name="ss_image" value="<?php echo implode(',',@$ss_image); ?>" id="ss_image" />

                                                <?php }else{ ?> 
                                                        <input type="hidden" name="ss_image" value="" id="ss_image" />

                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">Slider Section</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Image Upload</label>
                                                <div class="imgGallery"> </div>
                                                <div class="dropzone" id="sliderImageDropzone"></div>
                                                

                                                 <?php if(!empty($slider_image)){ ?> 
                                                        <input type="hidden" name="sliderImage" value="<?php echo implode(',',@$slider_image); ?>" id="sliderImage" />

                                                <?php }else{ ?> 
                                                        <input type="hidden" name="sliderImage" value="" id="sliderImage" />

                                                <?php } ?>
                                               
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    <!---->
    <?php include_once('common/commonjs.php'); ?>
    <script src="<?php echo $url; ?>admin/assets/js/ckeditor/ckeditor.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
    <script src="assets/js/bootstrap-multiselect.js"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('editor1', {
                extraPlugins: 'uploadimage',

                filebrowserImageUploadUrl: '<?php echo $url; ?>upload?command=QuickUpload&type=Images',

                  
                  removeButtons: 'PasteFromWord'
            });
            CKEDITOR.instances.editor1.on('change', function() {
                if (CKEDITOR.instances.editor1.getData().length > 0) {
                    $('label[for="editor1"]').hide();
                } else {
                    $('label[for="editor1"]').show();
                }
            });
            CKEDITOR.replace('fs_description', {
                extraPlugins: 'uploadimage',

                filebrowserImageUploadUrl: '<?php echo $url; ?>upload?command=QuickUpload&type=Images',

                  
                  removeButtons: 'PasteFromWord'
            });
            CKEDITOR.instances.fs_description.on('change', function() {
                if (CKEDITOR.instances.fs_description.getData().length > 0) {
                    $('label[for="fs_description"]').hide();
                } else {
                    $('label[for="fs_description"]').show();
                }
            });
        });


        $(document).ready(function() {
            $('#example-getting-started').multiselect();
        });

        $(function() {
            $("form[name='portfolioForm']").validate({
                // Define validation rules
                ignore: [],
                debug: false,
                rules: {
                    category_id: {
                        required: true
                    },
                    title: {
                        required: true,

                    },
                    tags: {
                        required: true,

                    },
                    heading: {
                        required: true
                    },
                    sub_heading: {
                        required: true
                    },
                    short_desc: {
                        required: true
                    },
                    image_text: {
                        required: true
                    },
                    editor1: {
                        required: function(textarea) {
                            CKEDITOR.instances[textarea.id].updateElement();
                            var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                            return editorcontent.length === 0;
                        }
                    },
                    fs_description: {
                        required: function(textarea) {
                            CKEDITOR.instances[textarea.id].updateElement();
                            var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                            return editorcontent.length === 0;
                        }
                    },
                    fs_heading: {
                        required: true
                    },
                    fs_sub_heading: {
                        required: true
                    },
                    date: {
                        required: true
                    }

                },
                messages: {
                    title: "This field is required.",
                    tags: "This field is required.",
                    heading: "This field is required.",
                    category_id: "This field is required.",
                    sub_heading: "This field is required.",
                    short_desc: "This field is required.",
                    image_text: "This field is required.",
                    editor1: {
                        required: "This field is required"
                    },
                    fs_description: {
                        required: "This field is required"
                    },
                    fs_heading: "This field is required.",
                    fs_sub_heading: "This field is required.",
                    date: "This field is required.",
                },
                /* use below section if required to place the error*/
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "editor1") {
                        error.insertAfter("#cke_editor1");
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

    </script>
  
    <script src="https://unpkg.com/@jcubic/tagger@0.x.x/tagger.js"></script>
    <script>
        
        file_list = null;
        <?php
            if(!empty($image)){
                if(file_exists("../assets/portfolioimage/".$image)){
                    $size = filesize("../assets/portfolioimage/".$image);
        ?>

                    file_list = {'name':'<?php echo $image; ?>','size':'<?php echo $size; ?>','path':'<?php echo $url."/assets/portfolioimage/".$image ;?>'};
        <?php
                }
            }
        ?>
        Dropzone.options.myDropzone= {
            url: '<?php echo $url; ?>upload',
            autoProcessQueue: true,
            uploadMultiple: false,
            parallelUploads: 5,
            maxFiles: 1,
            maxFilesize: 1,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            init: function() {
                dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
                <?php
                    if(!empty($image)){
                ?>
                        if(file_list){

                            var mockFile = { name: file_list.name, size: file_list.size };

                            this.emit("addedfile", mockFile);
                            this.emit("thumbnail", mockFile, file_list.path);
                            this.emit("complete", mockFile);
                        }
                <?php
                    }
                ?>

                this.on("removedfile", function(file) {
                    var file = $("#mainImage").val();
                    if(file==""){
                        return;
                    }
                    $.ajax({
                        url: "<?php echo $url; ?>remove_file",
                        type:'post',
                        data:{file:file,id:'<?php echo @$_GET['id']; ?>'}, 
                        success: function(result){
                            $("#mainImage").val("");
                        }
                    });
                });

                this.on("error", function (file) {
                    
                    alert("please enter image file have size max 1MB");
                    dzClosure.removeFile(file);
                    
                });
            },
            success: function(file, response){
                file = JSON.parse(response);
                $("#mainImage").val(file.file);
            }
        }
        var file_list_first_section = [];
        <?php
            if(!empty($fs_image)){
                foreach ($fs_image as $key=>$value) {
                    if(file_exists("../assets/portfolioimage/".$value)){

                        $size = filesize("../assets/portfolioimage/".$value);
        ?>

                        file_list_first_section[<?php echo $key ?>] = {'name':'<?php echo $value; ?>','size':'<?php echo $size; ?>','path':'<?php echo $url."/assets/portfolioimage/".$value ;?>'};
        <?php
                    }
                }
            }
        ?>

        Dropzone.options.fsimageDropzone= {
            url: '<?php echo $url; ?>upload',
            autoProcessQueue: true,
            uploadMultiple: false,
            parallelUploads: 5,
            maxFiles: 5,
            maxFilesize: 1,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            init: function() {
                dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
                <?php
                    if(!empty($fs_image)){
                ?>
                        $.each(file_list_first_section, function(key,value) {
                            var mockFile = { name: value.name, size: value.size,serverId: value.name};

                            dzClosure.emit("addedfile", mockFile);
                            dzClosure.emit("thumbnail", mockFile, value.path);
                            dzClosure.emit("complete", mockFile);
                        });
                <?php
                    }
                ?>
                this.on("removedfile", function(file) {
                    if (!file.serverId) {
                        return;
                    }
                    
                    $.ajax({
                        url: "<?php echo $url; ?>remove_file",
                        type:'post',
                        data:{file:file.serverId,id:'<?php echo @$_GET['id']; ?>'}, 
                        success: function(result){
                            $("#fs_image").val($("#fs_image").val().replace(file.serverId, ""));
                        }
                    });
                });
                this.on("error", function (file) {
                    
                    alert("please enter image file have size max 1MB");
                    dzClosure.removeFile(file);
                    
                });
            },
            success: function(file, response){
                response = JSON.parse(response);
                var current_file = $("#fs_image").val();
                if(current_file!=""){
                    $("#fs_image").val(current_file+','+response.file);
                }else{
                    $("#fs_image").val(response.file);
                }
                file.serverId = response.file;
            }
        }

        var file_list_second_section = [];
        <?php
            if(!empty($ss_image)){
                foreach ($ss_image as $key=>$value) {
                    if(file_exists("../assets/portfolioimage/".$value)){

                        $size = filesize("../assets/portfolioimage/".$value);
        ?>

                    file_list_second_section[<?php echo $key ?>] = {'name':'<?php echo $value; ?>','size':'<?php echo $size; ?>','path':'<?php echo $url."/assets/portfolioimage/".$value ;?>'};
        <?php
                    }
                }
            }
        ?>

        Dropzone.options.ssimageDropzone= {
            url: '<?php echo $url; ?>upload',
            autoProcessQueue: true,
            uploadMultiple: false,
            parallelUploads: 5,
            maxFiles: 5,
            maxFilesize: 1,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            init: function() {
                dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
                <?php
                    if(!empty($ss_image)){
                ?>
                        $.each(file_list_second_section, function(key,value) {
                            var mockFile = { name: value.name, size: value.size,serverId: value.name};

                            dzClosure.emit("addedfile", mockFile);
                            dzClosure.emit("thumbnail", mockFile, value.path);
                            dzClosure.emit("complete", mockFile);
                        });
                <?php
                    }
                ?>
                this.on("removedfile", function(file) {
                    if (!file.serverId) {
                        return;
                    }
                    
                    $.ajax({
                        url: "<?php echo $url; ?>remove_file",
                        type:'post',
                        data:{file:file.serverId,id:'<?php echo @$_GET['id']; ?>'}, 
                        success: function(result){
                            $("#ss_image").val($("#ss_image").val().replace(file.serverId, ""));
                        }
                    });
                });
                this.on("error", function (file) {
                    
                    alert("please enter image file have size max 1MB");
                    dzClosure.removeFile(file);
                    
                });
            },
            success: function(file, response){
                response = JSON.parse(response);
                var current_file = $("#ss_image").val();
                if(current_file!=""){
                    $("#ss_image").val(current_file+','+response.file);
                }else{
                    $("#ss_image").val(response.file);
                }
                file.serverId = response.file;
            }
        }

        var file_list_slider_section = [];
        <?php
            if(!empty($slider_image)){
                foreach ($slider_image as $key=>$value) {
                    if(file_exists("../assets/portfolioimage/".$value)){

                        $size = filesize("../assets/portfolioimage/".$value);
        ?>

                        file_list_slider_section[<?php echo $key ?>] = {'name':'<?php echo $value; ?>','size':'<?php echo $size; ?>','path':'<?php echo $url."/assets/portfolioimage/".$value ;?>'};
        <?php
                    }
                }
            }
        ?>


        Dropzone.options.sliderImageDropzone= {
            url: '<?php echo $url; ?>upload',
            autoProcessQueue: true,
            uploadMultiple: false,
            parallelUploads: 5,
            maxFiles: 5,
            maxFilesize: 1,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            init: function() {
                dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
                <?php
                    if(!empty($slider_image)){
                ?>
                        $.each(file_list_slider_section, function(key,value) {
                            var mockFile = { name: value.name, size: value.size,serverId: value.name};

                            dzClosure.emit("addedfile", mockFile);
                            dzClosure.emit("thumbnail", mockFile, value.path);
                            dzClosure.emit("complete", mockFile);
                        });
                <?php
                    }
                ?>
                this.on("removedfile", function(file) {
                    if (!file.serverId) {
                        return;
                    }
                    
                    $.ajax({
                        url: "<?php echo $url; ?>remove_file",
                        type:'post',
                        data:{file:file.serverId,id:'<?php echo @$_GET['id']; ?>'}, 
                        success: function(result){
                            $("#sliderImage").val($("#sliderImage").val().replace(file.serverId, ""));
                        }
                    });
                });
                this.on("error", function (file) {
                    
                    alert("please enter image file have size max 1MB");
                    dzClosure.removeFile(file);
                    
                });
            },
            success: function(file, response){
                response = JSON.parse(response);
                var current_file = $("#sliderImage").val();
                if(current_file!=""){
                    $("#sliderImage").val(current_file+','+response.file);
                }else{
                    $("#sliderImage").val(response.file);
                }
                file.serverId = response.file;
            }
        }
    </script>
</body>
</html>