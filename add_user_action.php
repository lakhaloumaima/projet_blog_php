<html>
<head>
	<title>Add Data</title>
</head>

<body>
<?php
//including the database connection file
require_once("config.php");
session_start();
if(isset($_POST['Submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	// checking empty fields
	if(empty($username) || empty($password) || empty($email)) {

		if(empty($username)) {
			echo "<font color='red'>Username field is empty.</font><br/>";
		}

		if(empty($password)) {
			echo "<font color='red'>Password field is empty.</font><br/>";
		}

		if(empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}

		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else {
		// if all the fields are filled (not empty)

		//insert data to database
		$sql = "INSERT INTO users(email ,username , password ) VALUES(:email , :username,  :password )";
		$query = $dbConn->prepare($sql);

		$query->bindparam(':username', $username);
		$query->bindparam(':email', $email);
		$query->bindparam(':password', $password);
		$query->execute();

		// Alternative to above bindparam and execute
		// $query->execute(array(':name' => $name, ':email' => $email, ':age' => $age));

		//display success message
		// echo "<font color='green'>Data added successfully.";
		// echo "<br/><a href='index.php'>View Result</a>";
		header('Location: index.php');
	}
}
?>
</body>
</html>