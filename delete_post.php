<?php

require_once("includes/config.php");

$postID = filter_input(INPUT_POST, 'PostID', FILTER_VALIDATE_INT);
$postTitle = filter_input(INPUT_POST, 'postTitle');

if ($postID == NULL || $postTitle == NULL) {
    include("index.php");
    exit();
} else {
    $query = "DELETE FROM blog_posts where postTitle= :postTitle";
    $statement = $db->prepare($query);
    $statement->bindValue(":oostTitle", $postTitle);
    $statement->execute();
    $statement->closeCursor();
    include("index.php");
    exit();
}
