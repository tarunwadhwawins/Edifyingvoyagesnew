<?php
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $current_page = str_replace($url, "", $current_url);
    if($current_page == ""){
        $current_page = "/";
    }
    $res = mysqli_query($conn, "select * from meta_tags where slug='$current_page'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $title = $row['title'];
      $keyword = $row['keyword'];
      $description = $row['description'];
    }else{
        $title = "";
        $keyword = "";
        $description = "";
    }
?>
  <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php echo $keyword; ?>" />
    <meta name="description" content="<?php echo $description; ?>" />
    <meta name="robots" content="follow, index" />
    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
    <meta property="og:site_name" content="" /> <!-- website name -->
    <meta property="og:site" content="" /> <!-- website link -->
    <meta property="og:title" content="" /> <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
    <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
    <meta property="og:type" content="article" />
    <link rel="canonical" href="<?php echo $current_url; ?>" />