<?php
//including the database connection file
include_once("config.php");
include("functions.php");

session_start();
$user_id = $_SESSION['user_id'];
//fetching data in descending order (lastest entry first)

#$resultPosts = $dbConn->query("SELECT * FROM posts  WHERE nb_report < 3 ");

if(isset($_GET['title'])) {
  // Retrieve the search term from the form data
  $search_term = $_GET['title'];

  // Execute a PDO query to search for posts by title
  $stmt = $dbConn->prepare("SELECT * FROM posts WHERE title LIKE :search_term");
  $stmt->bindValue(':search_term', '%' . $search_term . '%');
  $stmt->execute();
  $resultPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  // If no search term is provided, retrieve post
  $stmt = $dbConn->query("SELECT * FROM posts WHERE nb_report < 3 ");
  $resultPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

}


// if(isset($_GET['like'])) {

// 	$nb_like = $_GET['nb_like'] ;
// 	$id = $_GET['id'] ;
// 	#$user_id = 2 ;
// 	// checking empty fields
// 		// if all the fields are filled (not empty)

// 		//update data to database
// 		$sql = "UPDATE posts set nb_like = :nb_like WHERE id = :id";
// 		$query = $dbConn->prepare($sql);

// 		$query->bindparam(':nb_like', $nb_like + 1 );

// 		$query->execute();

// 		// Alternative to above bindparam and execute
// 		// $query->execute(array(':name' => $name, ':email' => $email, ':age' => $age));

// 		//display success message
// 		echo "<font color='green'>Data added successfully.";
// 		echo "<br/><a href='index_posts.php'> View Result </a>";
// 		header('Location: index_posts.php');

// }

if ( !($user_id))  {
	header("Location: login.php");
}

$post_id=$_GET['id'];
$sql="SELECT * FROM posts WHERE id=:id";
$stmt=$dbConn->prepare($sql);
$stmt->bindParam(':id', $post_id ,PDO::PARAM_INT);

	$stmt->execute();
	$row=$stmt->fetch();
	$title=$row['title'];
	$desc=$row['desc'];
	$post_id=$row['id'];




?>


<html>
<head>
	<title>Home Page</title>

</head>

<body>
<?php
 	include_once( "sidebar.php") ;
?>

			<!-- Begin Page Content -->
			<div class="container-fluid">

				<div class="d-sm-flex align-items-center justify-content-between mb-4">
					<h1 class="mb-0"> Welcome, <?php echo $_SESSION['username']; ?> !! </h1>
					<a href="add_post.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
							class="fas fa-download fa-sm text-white-50"></i> Add Post </a>
				</div>

                <div class="card-group">
					<?php foreach ($resultPosts as $row): {
						echo   "<div class='card'>" ;
						echo   "<div class='card-body'> " ;
						echo   "<h5 class='card-title'>" .$row['title']. "</h5>" ;
						echo   " <p class='card-text'> ".$row['desc']." </p>" ;
						echo  "" ; if( $user_id === $row['user_id'] ): "<td><a href=\"editPost.php?id=$row[id]\"><i class='fas fa-edit fa-sm fa-fw mr-2 text-green-600'></i></a> | <a href=\"deletePost.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\"><i class='fas fa-trash fa-sm fa-fw mr-2 text-red-600'></i></a></td>"; endif ;
						echo   "<td><form method='GET' ><input type='hidden' name='id' value=".$row['id']. "></form></td> "  ;
						echo  "<button class='btn btn-primary' name='like' >".$row['nb_like']. "$nbsp <i class='fa fa-thumbs-up fa-lg' aria-hidden='true'></i></button>  " ;
						echo  "<button class='btn btn-primary' name='dislike' >".$row['nb_dislike']. "$nbsp <i class='fa fa-thumbs-down fa-lg' aria-hidden='true'></i></button>  "  ;

						echo "<div>" ;
						echo "<i " ;
								if(userLikesDislikes($row['post_id'],$user_id,'like', $dbConn )):
								echo "class='fa fa-thumbs-up like-btn' " ; ?>
								<?php else:
									echo "class='fa fa-thumbs-o-up like-btn' " ;
								 endif ;

								echo "data-id='<?php echo " .$row['post_id']. " ?>'> </i> " ;
								echo "<span class='likes'>" ;
							    getLikesDislikes( $row['post_id'] ,'like', $dbConn );
								echo "</span> &nbsp;&nbsp;&nbsp;&nbsp;<i"  ;
								if (userLikesDislikes($row['post_id'],$user_id,'dislike', $dbConn )):
								echo	"class='fa fa-thumbs-down dislike-btn' " ; ?>
								<?php else: ?>
								<?php echo	"class='fa fa-thumbs-o-down dislike-btn' " ;
								 endif ;
								echo "data-id=" .$row['post_id']. ""  ;
								echo "</i><span class='dislikes'>" ;
								getLikesDislikes( $row['post_id'] ,'dislike', $dbConn );
								echo "</span> </div>" ;

						echo  "</div> " ;
						echo  "</div> " ;
						echo" </div> " ;
					}
					endforeach; ?>
                </div>
			</div>
			<!-- /.container-fluid -->

		</div>
		<!-- End of Main Content -->


	</div>
	<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Bootstrap core JavaScript-->
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


	<?php if ($test): ?>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
	Launch static backdrop modal
	</button>

	<!-- Modal -->
	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			...
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Understood</button>
		</div>
		</div>
	</div>
	</div>
	<?php endif ?>
</body>
</html>
