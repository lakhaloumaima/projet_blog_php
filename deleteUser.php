<?php
//including the database connection file
include("config.php");
session_start();
//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$sql = "DELETE FROM users WHERE id=:id";
$query = $dbConn->prepare($sql);
$query->execute(array(':id' => $id));

$sql = "DELETE FROM posts WHERE user_id=:id ";
$query = $dbConn->prepare($sql);
$query->execute(array(':id' => $id));

//redirecting to index.php
header("Location:index.php");
?>
