<?php
require_once('core/dbconnection.php');
if (isset($_FILES['upload']) && $_FILES['upload']['name'] != '') {
    //$image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
    $image = time().rand(10,100)."_".str_replace(" ", "_", $_FILES['upload']['name']);
    $extension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($extension, $allowed_extensions)) {
        $msg1 = "Invalid format. Only jpg / jpeg/ png /gif format allowed";
    } else {
        $path = date("Y");

        if(!is_dir('./assets/images/'.$path)){
            mkdir('./assets/images/'.$path);
            
        }
        $path .= "/".date("m");
        if(!is_dir('./assets/images/'.$path)){
            mkdir('./assets/images/'.$path);
        }
        $path .= "/";

        $FileUpload = move_uploaded_file($_FILES['upload']['tmp_name'], './assets/images/'.$path . $image);
        if (!$FileUpload) {
            $msg1 = "Error in file uploading. Please try again.";
        }
        

        $array["fileName"]=$image;
        $array["file"]=$image;
        $array["uploaded"]=1;
        $array["url"]= $url.'assets/images/'.$path . $image;
        
        echo json_encode($array);die;
    }
} else {
    $image = '';
}