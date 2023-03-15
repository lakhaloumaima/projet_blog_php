<?php
//including the database connection file
include("config.php");
session_start();
//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$sql = "DELETE FROM posts WHERE id=:id";
$query = $dbConn->prepare($sql);
$query->execute(array(':id' => $id));

//redirecting to index_posts.php
header("Location:index_posts.php");
?>
