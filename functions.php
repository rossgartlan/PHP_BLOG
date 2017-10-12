<?php

require_once 'includes/database.php';

$query = "SELECT max(id) from users";
$statement1 = $db->prepare($query);
$statement1->execute();
$total = $statement1->fetchColumn();
$statement1->closeCursor();


function getName() {
    
}

function cwUpload($db='', $field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = '') {
    //folder path setup
    $target_path = $target_folder;
    $thumb_path = $thumb_folder;

    $dsn = "mysql:host=localhost;dbname=user";
    $username = "root";
    $password = "";


    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT max(id) from users";
    $statement1 = $db->prepare($query);
    $statement1->execute();
    $total = $statement1->fetchColumn();
    $statement1->closeCursor();
    $total++;
    $total++;
    $total = $total + 15;
    
    

    //file name setup
    $filename_err = explode(".", $_FILES[$field_name]['name']);
    $filename_err_count = count($filename_err);
    //$file_ext = $filename_err[$filename_err_count - 1];
    $file_ext = "png";
    if ($file_name != '') {
        $fileName = $total . '.' . $file_ext;
    } else {
        $fileName = $total. '.' . $file_ext;
    }

    //upload image path
    $upload_image = $target_path . basename($fileName);

    //upload image
    if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $upload_image)) {
        //thumbnail creation
        if ($thumb == TRUE) {
            $thumbnail = $thumb_path . $fileName;
            list($width, $height) = getimagesize($upload_image);
            $thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);
            switch ($file_ext) {
                case 'jpg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;
                case 'png':
                    $source = imagecreatefrompng($upload_image);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($upload_image);
                    break;
                default:
                    $source = imagecreatefromjpeg($upload_image);
            }
            imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
            switch ($file_ext) {
                case 'jpg' || 'jpeg':
                    imagejpeg($thumb_create, $thumbnail, 100);
                    break;
                case 'png':
                    imagepng($thumb_create, $thumbnail, 100);
                    break;
                case 'gif':
                    imagegif($thumb_create, $thumbnail, 100);
                    break;
                default:
                    imagejpeg($thumb_create, $thumbnail, 100);
            }
        }

        return $fileName;
    } else {
        return false;
    }
}

if (!empty($_FILES['image']['name'])) {

    //call thumbnail creation function and store thumbnail name
    $upload_img = cwUpload('0','image', 'uploads/', '', TRUE, 'uploads/thumbs/', '200', '160');

    //full path of the thumbnail image
    $thumb_src = 'uploads/thumbs/' . $upload_img;

    //set success and error messages
    $message = $upload_img ? "<span style='color:#008000;'>Image thumbnail have been created successfully.</span>" : "<span style='color:#F00000;'>Some error occurred, please try again.</span>";
} else {

    //if form is not submitted, below variable should be blank
    $thumb_src = '';
    $message = '';
}
