<?php
require_once 'Constants.php';
//print_r($_FILES);
$error = false;
if (isset($_POST['submit'])) {
    print_r($_FILES);
    if ($_FILES["image"]["size"] >= IMAGE_SIZE) {
        echo "image is too big";
        $error = true;
        die();
    } else {
        $imageData = @getimagesize($_FILES["imagefile"]["tmp_name"]);
        print_r($imageData);
        if ($_FILES["image"]["type"] != "image/png") {
            echo "image type nust be in png format";
            $error = true;
            die();
        }
    }
}

require_once 'functions.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Image Upload and Thumbnail Creation using PHP</title>
        
    </head>
    <body>
        <li><a href="index.php">Home</a></li>
        <div class="messages"><?php echo $message; ?></div>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="image"/>
            <div class="form-group">
            <input type="submit" name="submit" value="Upload"/>
            <span class="text-danger"><?php if (isset($error)) echo htmlspecialchars($error, ENT_QUOTES); ?></span>
            </div>
        </form>
        <?php if ($thumb_src != '') { ?>
            <div class="gallery">
                <ul>
                    <img src="<?php echo $thumb_src; ?>" alt="">
                </ul>
            </div>
        <?php } ?>
    </body>
</html>