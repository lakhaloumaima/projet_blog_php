
<?php
//including the database connection file
include_once("config.php");

session_start();

if(isset($_POST['update'])) {
	$title = $_POST['title'];
	$desc = $_POST['desc'];
	$nb_report = 0 ;
	$nb_like = 0 ;
	$nb_dislike = 0 ;
	$user_id = 2 ;
	// checking empty fields
	if(empty($title) || empty($desc) ) {

		if(empty($title)) {
			echo "<font color='red'> Title field is empty.</font><br/>";
		}

		if(empty($desc)) {
			echo "<font color='red'>desc field is empty.</font><br/>";
		}

		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else {
		// if all the fields are filled (not empty)

		//insert data to database
		$sql = "INSERT INTO posts(title  , desc ,nb_report ,nb_like , nb_dislike , user_id ) VALUES(:title , :desc ,:nb_report , :nb_like ,:nb_dislike , :user_id )";
		$query = $dbConn->prepare($sql);

		$query->bindparam(':title', $title);
		$query->bindparam(':desc', $desc);
		$query->bindParam(':nb_report', $nb_report );
		$query->bindParam(':nb_like',  $nb_like );
		$query->bindParam(':nb_dislike', $nb_dislike );
		$query->bindParam(':user_id', $user_id );

		$query->execute();

		// Alternative to above bindparam and execute
		// $query->execute(array(':name' => $name, ':email' => $email, ':age' => $age));

		//display success message
		echo "<font color='green'>Data added successfully.";
		echo "<br/><a href='index_posts.php'>View Result</a>";
		header('Location: index_posts.php');
	}
}

?>
