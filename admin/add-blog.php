<?php
require_once('../core/ajax.php');
$seo_title = $seo_keyword = $seo_desc = $title = $slug = $date = $short_desc = $desc1 = $image = $Blogurl = $msg = '';
$image_required = 'required';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($conn, $_GET['id']);
    $res = mysqli_query($conn, "select * from blogs where id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {

        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $slug = $row['slug'];
        $short_desc = $row['short_desc'];
        $desc1 = $row['desc1'];
        $date = $row['date'];
        $image = $row['image'];
        $Blogurl = $row['url'];
    } else {
        header('location:blogs.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $title = get_safe_value($conn, $_POST['title']);
    $short_desc = get_safe_value($conn, $_POST['short_desc']);
    $desc1 = get_safe_value($conn, $_POST['editor1']);
    $date = get_safe_value($conn, $_POST['date']);
    $Blogurl = get_safe_value($conn, $_POST['url']);
    $slug1 = str_replace(' ', '-', $title);
    $slug = trim(strtolower($slug1), "?");

    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $image = $_FILES['image']['name'];
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($extension, $allowed_extensions)) {
            $msg1 = "Invalid format. Only jpg / jpeg/ png /gif format allowed";
        } else {
            $FileUpload = move_uploaded_file($_FILES['image']['tmp_name'], '../assets/blogimages/' . $image);
            if (!$FileUpload) {
                $msg1 = "Error in file uploading. Please try again.";
            }
        }
    } else {
        $image = '';
    }

    $res = mysqli_query($conn, "select * from blogs where title='$title'");
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
            if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
                $update_sql = "update blogs set   title='$title', slug='$slug', short_desc='$short_desc' , desc1='$desc1', date='$date', image='$image',  url='$Blogurl'  where id='$id'";
            } else {
                $update_sql = "update blogs set title='$title', slug='$slug' , short_desc='$short_desc' ,desc1='$desc1', date='$date' ,  url='$Blogurl'  where id='$id'";
            }
            mysqli_query($conn, $update_sql);
            session_start();
            $_SESSION['success_message'] = "Data Updated successfully.";
        } else {
            mysqli_query($conn, "insert into blogs (title, slug , short_desc ,desc1,  image, url , status, date) 
            values('$title', '$slug' , '$short_desc' ,'$desc1', '$image', '$Blogurl' , '1', '$date' )");


            session_start();
            $_SESSION['success_message'] = "Data inserted successfully.";
        }

        header('location:add-blog.php');
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
    <title>Blogs</title>
    <!---->
    <?php include_once('common/commoncss.php'); ?>
    <link rel="stylesheet" href="https://unpkg.com/@jcubic/tagger@0.x.x/tagger.css" />
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
                    <a class="btn btn-primary" href="blogs.php">Back</a>
                </div>
            </div>
            <div class="whiteBg">
                <h2>Blogs</h2>
                <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
                    <div id="successMessage" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
                <?php
                    unset($_SESSION['success_message']);
                }
                ?>
                <form method="post" name="blogForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label>Page Title</label>
                                <input type="text" name="title" id="title" value="<?php echo $title ?>" class="form-control" placeholder="Enter Title" required />
                                <span><?php echo $msg ?></span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Date</label>
                                <?php
                                //  $date;
                                //  $newDate = date("m-d-Y", strtotime($date));
                                //  $newDate;
                                if ($date != '') {
                                    $val = date('Y-m-d', strtotime($date));
                                } else {
                                    $val = '';
                                }
                                ?>
                                <input type="date" name="date" id="date" value="<?php echo $val ?>" class="form-control" placeholder="Enter Title" required />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea class="form-control" name="short_desc" placeholder="Enter Short Description"><?php echo $short_desc ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Page Description</label>
                                <textarea name="editor1" id="editor1" required><?php echo $desc1 ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Images Upload</label>
                                <div class="btnWrapper" style="display: <?php echo ($image == '') ? 'none' : 'flex'; ?>;" id='ImageBlock'>
                                    <div class="image-inner">
                                        <img id="output_image" width="100" height="60" src="../assets/blogimages/<?php echo $image ?>" />
                                    </div>
                                    <div class="fileName"><?php echo ($image != '') ? $image : ''; ?></div>
                                    <div class="crossIcon" id="crossIcon" onclick="HideImageButton()"><i class="fa fa-times"></i></div>
                                </div>
                                <div class="upload-btn-wrapper" id="imageUpload">
                                    <button class="btn" name="image"><i class="fa fa-cloud-upload"></i>Upload a file</button>
                                    <input type="file" name="image" id="image" accept="image/*" onchange="preview_image(event)" value="<?php echo $image ?>" class="form-control" <?php echo $image_required ?> />
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-sm-12">
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" name="url" id="url" value="<?php echo $Blogurl ?>" class="form-control" placeholder="Enter Url" required/>
                        </div>
                    </div> -->
                        <div class="col-sm-12">
                            <hr>
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
    <script src="<?php echo $url; ?>admin/assets/js/ckeditor/ckeditor.js"></script>
    <!---->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            
            CKEDITOR.replace('editor1', {
                extraPlugins: 'uploadimage',

                filebrowserImageUploadUrl: '<?php echo $url; ?>upload?command=QuickUpload&type=Images',

                  
                  removeButtons: 'PasteFromWord'
            });
            CKEDITOR.instances.editor1.on('change', function() {    
                if(CKEDITOR.instances.editor1.getData().length >  0) {
                    $('label[for="editor1"]').hide();
                }
                else
                {
                    $('label[for="editor1"]').show();
                }
            });
        });

        
        $(function() {
            $("form[name='blogForm']").validate({
                // Define validation rules
                ignore: [],
                  debug: false,
                rules: {
                    title: {
                        required: true,
                    },
                    short_desc: {
                        required: true,
                    },
                    editor1: {
                        required: function(textarea) {
                        CKEDITOR.instances[textarea.id].updateElement();
                            var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                            return editorcontent.length === 0;
                        }
                    },
                    url: {
                        required: true
                    },
                    date: {
                        required: true
                    }

                },
                // Specify validation error messages
                messages: { 
                    title: "This field is required.",
                    editor1: {
                        required: "This field is required"
                    },
                    short_desc: "This field is required.",
                    url: "This field is required.",
                    date: "This field is required.",
                },
                /* use below section if required to place the error*/
                errorPlacement: function(error, element) 
                {
                    if (element.attr("name") == "editor1") 
                    {
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

        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output_image');
                output.src = reader.result;
                $('#ImageBlock').show();
            }
            reader.readAsDataURL(event.target.files[0]);
            $('.fileName').html(event.target.files[0].name);
            $('#imageUpload').hide();
            $('#ImageBlock').show();
        }
        
        function HideImageButton() {
            $('#ImageBlock').hide();
            $('#imageUpload').show();
            $('#image').val('');
        }
        window.setTimeout("document.getElementById('successMessage').style.display='none';", 2000);
    </script>
    

</body>

</html>