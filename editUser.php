<?php
// including the database connection file
include_once("config.php");
session_start();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

	$username=$_POST['username'];
	$email=$_POST['email'];

	// checking empty fields
	if(empty($username) || empty($email)) {

		if(empty($username)) {
			echo "<font color='red'>username field is empty.</font><br/>";
		}

		if(empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}
	} else {
		//updating the table
		$sql = "UPDATE users SET `username` =:username, `email` =:email WHERE id=:user_id";
		$query = $dbConn->prepare($sql);

		#$query->bindparam(':id', $id);
		$query->bindparam(':username', $username);
		$query->bindparam(':email', $email);
		$query->execute();

		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php

//selecting data associated with this particular id
$sql = "SELECT * FROM users WHERE id=:user_id";
$query = $dbConn->prepare($sql);
$query->execute(array(':id' => $user_id));

while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$username = $row['username'];
	$email = $row['email'];
}
?>
<html>
<head>
	<title> Edit User </title>

</head>

<body>

	<?php
		include_once( "sidebar.php" ) ;
	?>

	<div class="container" >
		<a href="index.php"> Back to Dashboard  </a>
		<br/><br/>

		<form method="POST" >
				<tr>
					<td>Name</td>
					<td><input class="form-control" type="text" name="username" value="<?php echo $username;?>"></td>
				</tr>
				<br>
				<tr>
					<td>Email</td>
					<td><input class="form-control" type="email" name="email" value="<?php echo $email;?>"></td>
				</tr>
				<br>
				<tr>

					<td><input type="submit" name="update" value="Update" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" ></td>
				</tr>

		</form>
	</div>

</body>
</html>
