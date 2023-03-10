<?php
//including the database connection file
include_once("config.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$title = $_POST['title'];
	$desc = $_POST['desc'];
	$nb_report = $_POST['nb_report'];
	$nb_like = $_POST['nb_like'];
	$nb_dislike = $_POST['nb_dislike'];

	$user_id = $_SESSION['user_id'] ;
	// checking empty fields
	if(empty($title) || empty($desc) ) {

		if(empty($title)) {
			echo "<font color='red'> Title field is empty.</font><br/>";
		}

		if(empty($desc)) {
			echo "<font color='red'>desc field is empty.</font><br/>";
		}
		if(empty($user_id)) {
			echo "<font color='red'>desc field is empty.</font><br/>";
		}
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else {
		// if all the fields are filled (not empty)

		//insert data to database
		$sql = "INSERT INTO posts ( title,'desc' , nb_report , nb_like , nb_dislike , user_id ) VALUES (:title , :desc ,:nb_report , :nb_like ,:nb_dislike , :user_id  )";
		$query = $dbConn->prepare($sql);

		$query->bindparam(':title', $title);
		$query->bindparam(':desc', $desc);
		$query->bindparam(':nb_report', $nb_report);
		$query->bindparam(':nb_like',  $nb_like );
		$query->bindparam(':nb_dislike', $nb_dislike );
		$query->bindparam(':user_id' , $user_id);

		$query->execute();

		// Alternative to above bindparam and execute
		// $query->execute(array(':name' => $name, ':email' => $email, ':age' => $age));

		//display success message
		echo "<font color='green'>Data added successfully.";
		echo "<br/><a href='index_posts.php'>View Result</a>";
		#header('Location: index_posts.php');
	}
}

?>

<html>
<head>
	<title>Add Post </title>

</head>

<body>
	<?php
	include_once("sidebar.php") ;
	?>
	<div class="container" >
		<a href="index_posts.php"> Back to Dashboard </a>
		<br/><br/>

		<form action="" method="POST" >

				<tr>
					<td>Title </td>
					<td><input type="text" class="form-control" name="title"></td>
				</tr>
				<br>
				<tr>
					<td>Description </td>
					<td><input type="text" class="form-control" name="desc"></td>
				</tr>
				<br>
				<td><input type="hidden" name="nb_report" value="0" > </td>
				<td><input type="hidden" name="nb_like" value="0" > </td>
				<td><input type="hidden" name="nb_dislike" value="0" > </td>
				<td><input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>" ></td>
				<tr>
					<td><input type="submit" name="submit" value="Add" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"></td>
				</tr>

		</form>
	</div>

	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="js/sb-admin-2.min.js"></script>

	<!-- Page level plugins -->
	<script src="vendor/chart.js/Chart.min.js"></script>

	<!-- Page level custom scripts -->
	<script src="js/demo/chart-area-demo.js"></script>
	<script src="js/demo/chart-pie-demo.js"></script>

</body>
</html>
