
<?php
// including the database connection file
include_once("config.php");
session_start();
if(isset($_POST['update']))
{
	$id = $_GET['id'];

	$title=$_POST['title'];
	$desc=$_POST['desc'];

	// checking empty fields
	if(empty($title) || empty($desc)) {

		if(empty($title)) {
			echo "<font color='red'>title field is empty.</font><br/>";
		}

		if(empty($desc)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}
	} else {
		//updating the table
		$sql = "UPDATE users SET title=:title, desc=:desc WHERE id=:id";
		$query = $dbConn->prepare($sql);

		$query->bindparam(':id', $id);
		$query->bindparam(':title', $title);
		$query->bindparam(':desc', $desc);
		$query->execute();

		// Alternative to above bindparam and execute
		// $query->execute(array(':id' => $id, ':name' => $name, ':email' => $email, ':age' => $age));

		//redirectig to the display page. In our case, it is index.php
		header("Location: index_posts.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$sql = "SELECT * FROM posts WHERE id=:id";
$query = $dbConn->prepare($sql);
$query->execute(array(':id' => $id));

while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$title = $row['title'];
	$desc = $row['desc'];
}
?>
<html>
<head>
	<title>Edit Post </title>
</head>

<body>

	<?php
	include_once( "sidebar.php" ) ;
	?>

	<div class="container" >
		<a href="index.php"> Back to Dashboard  </a>
		<br/><br/>

		<form name="form1" method="post" >

				<tr>
					<td>Name</td>
					<td><input class="form-control" type="text" name="title" value="<?php echo $title;?>"></td>
				</tr>
				<br>
				<tr>
					<td>desc</td>
					<td><input class="form-control" type="desc" name="desc" value="<?php echo $desc;?>"></td>
				</tr>
				<br>
				<tr>
					<td><input type="hidden" name="user_id" value=<?php echo $_SESSION['user_id'];?>></td>
					<td><input type="submit" name="update" value="Update" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" ></td>
				</tr>

		</form>
	<div>

</body>
</html>
