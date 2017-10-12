<?php

session_start();
require_once("includes/database.php");


if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];

$postID = filter_input(INPUT_POST, "postID");
$commentId = filter_input(INPUT_POST, "comid");
$count = filter_input(INPUT_POST, "count");
//echo $postID;
//echo $commentId;
//echo $count;
$count++;
//print_r($count);
//echo $count;
$query2 = "select count(*) id from likes where commentID = :comid and userID = :id and id IN (select id from likes where liked=TRUE) ";
$statement3 = $db->prepare($query2);
$statement3->bindValue(':id', $id);
$statement3->bindValue(':comid', $commentId);
$statement3->execute();
$tot = $statement3->fetchColumn();
$statement3->closeCursor();

if ($tot < 1) {
    $query1 = "insert ignore into likes(userID,commentID,liked) VALUES (:id,:comid,TRUE)";
    $statement2 = $db->prepare($query1);
    $statement2->bindValue(':id', $id);
    $statement2->bindValue(':comid', $commentId);
    $statement2->execute();
    $statement2->closeCursor();
}

//print_r($tot);

if ($tot < 1) {
    $query = "UPDATE comments SET likes = '$count' WHERE commentID= :comid";
    $statement1 = $db->prepare($query);
    $statement1->bindValue(':comid', $commentId);
    $statement1->execute();
    $statement1->closeCursor();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
