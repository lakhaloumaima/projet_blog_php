<?php
//including the database connection file
include_once("config.php");

session_start();
    // Get user ID from session
    $user_id = $_SESSION['user_id'];

// Define createPost function
function createPost($vtitle, $vdesc, $user_id) {
    global $dbConn;
    // Prepare and execute SQL statement to insert post into database
    $stmt = $dbConn->prepare("INSERT INTO posts (`title`, `desc`, `nb_report`, `nb_like`, `nb_dislike`, `user_id`) VALUES (?, ?,?,?,?, ?)");
    $stmt->execute([$vtitle, $vdesc , 0,0,0 , $user_id]);
}

// Check if user is logged in
if (isset($user_id )) {

    // Get post data from form
    if (isset($_POST['title']) && isset($_POST['desc'])) {
		$vtitle = $_POST['title'];
        $vdesc = $_POST['desc'];

        // Call createPost function to insert post into database
        createPost($vtitle, $vdesc,  $user_id) ;
        echo "Post created successfully.";
		header('Location: index_posts.php');

    }
else {
    echo "Please log in to create a post.";
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

				<tr>
					<td><input type="submit" name="submit" value="Add" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"></td>
				</tr>

		</form>
	</div>


</body>
</html>
