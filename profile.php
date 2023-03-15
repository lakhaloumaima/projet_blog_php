
<?php
//including the database connection file
include_once("config.php");

session_start();
$user_id = $_SESSION['user_id'];
//fetching data in descending order (lastest entry first)

if(isset($_GET['search_term'])) {
  // Retrieve the search term from the form data
  $search_term = $_GET['search_term'];

  // Execute a PDO query to search for posts by title
  $stmt = $dbConn->prepare("SELECT * FROM posts WHERE title LIKE :search_term AND user_id = $user_id ");
  $stmt->bindValue(':search_term', '%' . $search_term . '%');
  $stmt->execute();
  $resultPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  // If no search term is provided, retrieve post
  $stmt = $dbConn->query("SELECT * FROM posts WHERE user_id = $user_id ");
  $resultPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

if ( !($user_id))  {
	header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

	$username=$_POST['username'];
	$email=$_POST['email'];

		//updating the table
        $stmt = $dbConn->prepare("UPDATE users SET `username` = :username, `email` = :email WHERE id = :user_id");
		$stmt->execute(array(':username' => $username, ':email' => $email , ':user_id' => $user_id ));

		// Check if the update was successful
		if ($stmt->rowCount() > 0) {
			header("Location: profile.php");
		}
}


//selecting data associated with this particular id
$sql = "SELECT * FROM users WHERE id=:user_id";
$query = $dbConn->prepare($sql);
$query->execute(array(':user_id' => $user_id));

while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$username = $row['username'];
	$email = $row['email'];
}



?>

<!DOCTYPE html>
<html>

<head>
    <title> Profile  </title>

</head>

<body>

    <?php
        include_once( "sidebar.php" ) ;
    ?>

<div class="container rounded bg-white mt-5 mb-2">
    <div class="row">
        <div class="col-md-4 border-right">
            <div class="d-flex flex-column p-3 py-2">
                <img class="rounded-circle mt-2"
                    width="120px"
                    src="../img/logo.png"> <br>
                <h3 class="text-black-50"><?php echo $email; ?> </h3><span> </span></div>
        </div>
        <div class="col-md-6 border-right">
            <div class="p-3 py-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <form  method="POST" >
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels"> Username </label><input name="username" type="text" class="form-control" value="<?php echo $username; ?>"></div>
                        <div class="col-md-6"><label class="labels"> Email </label><input name="email" type="email" class="form-control" value="<?php echo $email; ?>" ></div>
                    </div>
                    <div class="mt-5 text-center"><button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" type="submit" name="submit" >Save Profile</button></div>
                </form>
            </div>
        </div>

        <br>
        <!-- Begin Page Content -->

			<div class="container">

                <div class="d-sm-flex align-items-center justify-content-between mt-5 mb-4">
                    <a href="add_post.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Add Post </a>
                </div>

                    <?php foreach ($resultPosts as $row): {
                        echo "<div class='card-group'>" ;
                        echo "<div class='card row'>" ;
                        echo   "<div class='card-body'> " ;
                        echo    "<h3 class='card-title' style='float:left' >" .$row['title']. "</h3>" ;
                        echo "<div style='float:right' ><td ><a style='color:green' href=\"editPost.php?id=$row[id]\"><i class='fas fa-edit fa-sm fa-fw mr-2 text-green-600'></i></a> | <a style='color:red' href=\"deletePost.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\"><i class='fas fa-trash fa-sm fa-fw mr-2 text-red-600'></i></a></td></div>";
                        echo   " <p class='card-text' style='float:left'> ".$row['desc']." </p>" ;
                        echo " </div> " ;
                        echo " </div> " ;
                        echo " </div> " ;
                    }
                    endforeach; ?>
                </div>
                </div>
            </div>

    </div>


</div>


</body>

</html>