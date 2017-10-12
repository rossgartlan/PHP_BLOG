<?php
require_once("includes/database.php");

$query = 'UPDATE comments SET likes = likes + 1';
$statement = $db->prepare($query);
$statement->execute();
$statement->closeCursor();

$query = "SELECT max(id) from users";
$statement1 = $db->prepare($query);
$statement1->execute();
$total = $statement1->fetchColumn();
$statement1->closeCursor();

$result = "";
foreach($categories as $category) :
$result .=   '<li><a href=".?team_id=' . $category["teamID"] . '">' . $category["teamName"] . '</a></li>';
endforeach;

echo $result;
//echo "123";
//echo "123";