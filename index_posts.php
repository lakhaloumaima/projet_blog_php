<?php
//including the database connection file
include_once("config.php");

session_start();
$id = $_SESSION['user_id'];
//fetching data in descending order (lastest entry first)

$resultPosts = $dbConn->query("SELECT * FROM posts ORDER BY id DESC");

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
  $stmt = $dbConn->query("SELECT * FROM posts WHERE nb_report < 3 ORDER BY id DESC");
  $resultPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

include("functions.php");
$post_id=$_GET['id'];


if(isset($_GET['like'])) {

	$nb_like = $_GET['nb_like'] ;
	$id = $_GET['id'] ;
	#$user_id = 2 ;
	// checking empty fields
		// if all the fields are filled (not empty)

		//update data to database
		$sql = "UPDATE posts set nb_like = :nb_like WHERE id = :id";
		$query = $dbConn->prepare($sql);

		$query->bindparam(':nb_like', $nb_like + 1 );

		$query->execute();

		// Alternative to above bindparam and execute
		// $query->execute(array(':name' => $name, ':email' => $email, ':age' => $age));

		//display success message
		echo "<font color='green'>Data added successfully.";
		echo "<br/><a href='index_posts.php'> View Result </a>";
		header('Location: index_posts.php');

}

if ( !($id))  {
	header("Location: login.php");
}

$sql="SELECT * FROM posts WHERE id=:id"; 
$stmt=$dbConn->prepare($sql);
$stmt->bindParam(':id', $post_id ,PDO::PARAM_INT);
	$stmt->execute();
$row=$stmt->fetch();
$title=$row['title']; $desc=$row['desc']; $post_id=$row['id']; 

?>


<html>
<head>
	<title>Home Page</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Dashboard </title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<script src="like_dislike.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<!-- Page Wrapper -->
	<div id="wrapper">

	<!-- Sidebar -->
	<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

		<!-- Sidebar - Brand -->
		<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index_posts.php">
			<div class="sidebar-brand-icon rotate-n-15">
				<i class="fas fa-laugh-wink"></i>
			</div>
			<div class="sidebar-brand-text mx-3">User  <sup> * </sup></div>
		</a>

		<!-- Divider -->
		<hr class="sidebar-divider my-0">

		<!-- Nav Item - Dashboard -->
		<li class="nav-item active">
			<a class="nav-link" href="index_posts.php">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider">

		<!-- Heading -->
		<div class="sidebar-heading">
			Interface
		</div>

		<!-- Nav Item - Pages Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="index_posts.php" data-toggle="collapse" data-target="#collapseTwo"
				aria-expanded="true" aria-controls="collapseTwo">
				<i class="fas fa-fw fa-cog"></i>
				<span> Posts </span>
			</a>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<h6 class="collapse-header"> Actions : </h6>
					<a class="collapse-item" href="add_post.php">Add </a>
					<!-- <a class="collapse-item" href="editPost.php">Update </a>
					<a class="collapse-item" href="deletePost.php">Delete </a>
					<a class="collapse-item" href="likeOrDislike.php">Like / Dislike </a> -->
				</div>
			</div>
		</li>

		<!-- Nav Item - Utilities Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
				aria-expanded="true" aria-controls="collapseUtilities">
				<i class="fas fa-fw fa-wrench"></i>
				<span> My Profile </span>
			</a>
			<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
				data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<h6 class="collapse-header"> Update :</h6>
					<a class="collapse-item" href="profile.php">Informations </a>
				</div>
			</div>
		</li>



	</ul>
	<!-- End of Sidebar -->

	<!-- Content Wrapper -->
	<div id="content-wrapper" class="d-flex flex-column">

		<!-- Main Content -->
		<div id="content">

			<!-- Topbar -->
			<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

				<!-- Sidebar Toggle (Topbar) -->
				<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
					<i class="fa fa-bars"></i>
				</button>

				<!-- Topbar Search -->
				<form method="GET" action="index_posts.php"
					class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
					<div class="input-group">
						<input type="text" name="title"  class="form-control bg-light border-0 small" placeholder="Search for..."
							aria-label="Search" aria-describedby="basic-addon2">
						<div class="input-group-append">
							<button class="btn btn-primary" type="submit">
								<i class="fas fa-search fa-sm"></i>
							</button>
						</div>
					</div>
				</form>

				<div class="topbar-divider d-none d-sm-block"></div>
				<!-- Nav Item - User Information -->
				<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php echo $_SESSION['username']; ?>  </span>
								<img class="img-profile rounded-circle"
									src="img/undraw_profile.svg">
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
								aria-labelledby="userDropdown">
								<a class="dropdown-item" href="profile.php">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Profile
								</a>

								<div class="dropdown-divider"></div>
								<form action="logout.php" method="post">
									<a class="dropdown-item"  >
										<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
										<input type="submit" value="Logout" name="logout" >
									</a>
								</form>
							</div>
						</li>

			</nav>
			<!-- End of Topbar -->

			<!-- Begin Page Content -->
			<div class="container">

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
						echo   "<td><form method='GET' ><input type='hidden' name='id' value=".$row['id']. "></form></td> "  ;
						echo  "<button class='btn btn-primary' name='like' >".$row['nb_like']. "$nbsp <i class='fa fa-thumbs-up fa-lg' aria-hidden='true'></i></button>  " ;
						echo  "<button class='btn btn-primary' name='dislike' >".$row['nb_dislike']. "$nbsp <i class='fa fa-thumbs-down fa-lg' aria-hidden='true'></i></button>  "  ;
						echo" </div> " ;
						echo" </div> " ;
					}
					endforeach; ?>
					<div>
						<i <?php
								if(userLikesDislikes($row['post_id'],$user_id,'like',$dbConn)): ?>
									class="fa fa-thumbs-up like-btn"
								<?php else: ?>
									class="fa fa-thumbs-o-up like-btn"
								<?php endif ?>
								data-id="<?php echo $row['post_id'] ?>"></i>
								<span class="likes"><?php echo getLikesDislikes($row['post_id'],'like',$dbConn); ?></span>

								&nbsp;&nbsp;&nbsp;&nbsp;
								<i
								<?php if (userLikesDislikes($row['post_id'],$user_id,'dislike',$dbConn)): ?>
									class="fa fa-thumbs-down dislike-btn"
								<?php else: ?>
									class="fa fa-thumbs-o-down dislike-btn"
								<?php endif ?>
								data-id="<?php echo $row['post_id'] ?>"></i>
								<span class="dislikes"><?php echo getLikesDislikes($row['post_id'],'dislike',$dbConn); ?></span>
					</div>
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
