<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit(); 
}

require_once("includes/database.php");
$theComments = filter_input(INPUT_POST, "postcomments", FILTER_SANITIZE_STRING);
$theID = filter_input(INPUT_POST, "postid");
$theLikes = 0;
   
$poster = $_SESSION['id'];



$stmt = $db->query('SELECT postID, postTitle, postDesc, postDate, tags FROM blog_posts ORDER BY postID DESC');
$row = $stmt->fetch();



$error = false;

$badWords = array("ban","bad","user","pass","stack","name","html","fuck");

//$string = "Hello my name is user.";

$matches = array();
$matchFound = preg_match_all(
                "/\b(" . implode($badWords,"|") . ")\b/i", 
                $theComments, 
                $matches
              );

if ($matchFound) {
    $error = true;
  $words = array_unique($matches[0]);
  foreach($words as $word) {
    echo "<li>" . $word . "</li>";
  }
  echo "</ul>";
}

$error_message = "you have entered a banned word please go back and alter your comment";
$date =  date('Y-m-d H:i:s');

if ($theComments == NULL || $error==true) {
    
    //include("memberPage.php");
    echo $error_message;
    exit();

} else {

    $query = "INSERT INTO comments (postID,posterID,comment,likes,date) VALUES (:theID,:poster,:theComments,:theLikes,:date)";
    $statement1 = $db->prepare($query);
    $statement1->bindValue(':theComments', $theComments);
    $statement1->bindValue(':theLikes', $theLikes);
    $statement1->bindValue(':theID', $theID);
    $statement1->bindValue(':date', $date);
    $statement1->bindValue(':poster', $poster);
    
    $statement1->execute();   // no fetch as no results back
    $statement1->closeCursor();
    header("Location: memberPage.php");
    
   // header("Location :viewpost.php?id='" . $row['postID']);
    exit();
}
?>