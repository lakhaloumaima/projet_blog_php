<?php
//including the database connection file
include_once("config.php");

session_start();
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if(isset($_GET['search_term'])) {
  // Retrieve the search term from the form data
  $search_term = $_GET['search_term'];

  // Execute a PDO query to search for posts by title
  $stmt = $dbConn->prepare("SELECT * FROM posts WHERE ( title LIKE :search_term ) AND nb_report < 3 ORDER BY id DESC");
  $stmt->bindValue(':search_term', '%' . $search_term . '%');
  $stmt->execute();
  $resultPosts = $stmt->fetchAll();

} else {
  // If no search term is provided, retrieve post
  $stmt = $dbConn->query("SELECT posts.id, posts.title, posts.desc,posts.nb_report ,posts.nb_like ,posts.nb_dislike,posts.user_id , users.username FROM posts
  INNER JOIN users ON posts.user_id = users.id WHERE nb_report < 3 ORDER BY id DESC");
  $resultPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

}


if ( !($user_id))  {
	header("Location: login.php");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ( isset( $_POST['nb_report'] ) ) {
		$nb_report = $_POST['nb_report'] ;
		$post_id = $_POST['id'] ;
		$vote_type =  $_POST['vote_type']  ;
		// check if user has already reported the post
		$stmt = $dbConn->prepare("SELECT * FROM votes WHERE user_id = ? AND post_id = ? AND vote_type = 'report' ");
		$stmt->execute([ $user_id , $post_id ]);
		$vote = $stmt->fetch();

		if (!$vote) {
		// update nb_report in posts table
			$stmt = $dbConn->prepare("UPDATE posts SET `nb_report` = :nb_report + 1 WHERE id = :post_id ");
			$stmt->execute(array(':nb_report' => $nb_report  , ':post_id' => $post_id  ));
			# $stmt->execute([$post_id]);

			// insert vote record in votes table
			$stmt2 = $dbConn->prepare("INSERT INTO votes ( `user_id`, `post_id`, `vote_type` ) VALUES (?, ?, ? ) ");
			$stmt2->execute([ $user_id , $post_id,  $vote_type ]);
			header('Location: index_posts.php');
		} else {
			echo "<div  class='alert alert-danger' role='alert' > You already reported this post !! </div> ";
		// user has already reported the post
		// handle this case as needed, e.g. display an error message
		}
	}

	if ( isset( $_POST['nb_like'] ) ) {
		$nb_like = $_POST['nb_like'] ;
		$post_id = $_POST['id'] ;
		$vote_type =  $_POST['vote_type']  ;
		// check if user has already reported the post
		$stmt = $dbConn->prepare("SELECT * FROM votes WHERE vote_type = 'like' AND user_id = ? AND post_id = ?  ");
		$stmt->execute([ $user_id , $post_id ]);
		$vote = $stmt->fetch();

		if (!$vote) {
			$nb_dislike = $_POST['nb_dislike'] ;
			// check if user has already reported the post
			$stmtt = $dbConn->prepare("SELECT * FROM votes WHERE vote_type = 'dislike' AND user_id = ? AND post_id = ?  ");
			$stmtt->execute([ $user_id , $post_id ]);
			$votee = $stmtt->fetch();
			if ($votee) {
				// insert vote record in votes table
				$stmtt2 = $dbConn->prepare("DELETE FROM votes WHERE  vote_type = 'dislike' AND user_id = ? AND post_id = ? ");
				$stmtt2->execute([ $user_id , $post_id ]);
			// update nb_report in posts table
				$stmtt = $dbConn->prepare("UPDATE posts SET `nb_like` = :nb_like + 1 , `nb_dislike` = :nb_dislike - 1 WHERE id = :post_id ");
				$stmtt->execute(array(':nb_like' => $nb_like , ':nb_dislike' => $nb_dislike  , ':post_id' => $post_id  ));
				# $stmt->execute([$post_id]);

				$stmttt2 = $dbConn->prepare("INSERT INTO votes ( `user_id`, `post_id`, `vote_type` ) VALUES (?, ?, ? ) ");
				$stmttt2->execute([ $user_id , $post_id,  $vote_type ]);

				header('Location: index_posts.php');
			} else {
				// update nb_report in posts table
				$stmtt = $dbConn->prepare("UPDATE posts SET  `nb_like` = :nb_like + 1  WHERE id = :post_id ");
				$stmtt->execute(array(  ':nb_like' => $nb_like  , ':post_id' => $post_id  ));
				# $stmt->execute([$post_id]);

				$stmttt2 = $dbConn->prepare("INSERT INTO votes ( `user_id`, `post_id`, `vote_type` ) VALUES (?, ?, ? ) ");
				$stmttt2->execute([ $user_id , $post_id,  $vote_type ]);
				header('Location: index_posts.php');

			// user has already reported the post
			// handle this case as needed, e.g. display an error message
			}
		}
			else {
				# header('Location: index_posts.php');
				echo "<div  class='alert alert-danger' role='alert' > You already liked this post !! </div> ";
			}


	}

	if ( isset( $_POST['nb_dislikee'] ) ) {
		$nb_dislike = $_POST['nb_dislikee'] ;
		$post_id = $_POST['id'] ;
		$vote_type =  $_POST['vote_type']  ;
		$nb_like = $_POST['nb_likee'] ;

		$stmt = $dbConn->prepare("SELECT * FROM votes WHERE vote_type = 'dislike' AND user_id = ? AND post_id = ?  ");
		$stmt->execute([ $user_id , $post_id ]);
		$vote = $stmt->fetch();
		if (!$vote) {

			// check if user has already reported the post
			$stmtt = $dbConn->prepare("SELECT * FROM votes WHERE vote_type = 'like' AND user_id = ? AND post_id = ?  ");
			$stmtt->execute([ $user_id , $post_id ]);
			$votee = $stmtt->fetch();
			if ($votee) {
				// insert vote record in votes table
				$stmtt2 = $dbConn->prepare("DELETE FROM votes WHERE  vote_type = 'like' AND user_id = ? AND post_id = ? ");
				$stmtt2->execute([ $user_id , $post_id ]);
			// update nb_report in posts table
				$stmtt = $dbConn->prepare("UPDATE posts SET  `nb_dislike` = :nb_dislike + 1 , `nb_like` = :nb_like - 1  WHERE id = :post_id ");
				$stmtt->execute(array(  ':nb_dislike' => $nb_dislike  , ':nb_like' => $nb_like , ':post_id' => $post_id  ));
				# $stmt->execute([$post_id]);

				$stmttt2 = $dbConn->prepare("INSERT INTO votes ( `user_id`, `post_id`, `vote_type` ) VALUES (?, ?, ? ) ");
				$stmttt2->execute([ $user_id , $post_id,  $vote_type ]);

				header('Location: index_posts.php');
			} else {
				// update nb_report in posts table
				$stmtt = $dbConn->prepare("UPDATE posts SET  `nb_dislike` = :nb_dislike + 1  WHERE id = :post_id ");
				$stmtt->execute(array(  ':nb_dislike' => $nb_dislike  , ':post_id' => $post_id  ));
				# $stmt->execute([$post_id]);

				$stmttt2 = $dbConn->prepare("INSERT INTO votes ( `user_id`, `post_id`, `vote_type` ) VALUES (?, ?, ? ) ");
				$stmttt2->execute([ $user_id , $post_id,  $vote_type ]);
				header('Location: index_posts.php');
			// user has already reported the post
			// handle this case as needed, e.g. display an error message
			}
		}
		else {
			# header('Location: index_posts.php');
			echo "<div  class='alert alert-danger' role='alert' > You already unliked this post !! </div> ";
		}
		}
	}

?>


<html>
<head>
	<title>Home Page</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
	<style>
		h2 , h3 {
			color: black ;
		}
		button {
			float: right ;
		}
	</style>
</head>

<body>
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<?php if( $role == "user" ):
				echo  "<a class='sidebar-brand d-flex align-items-center justify-content-center' href='index_posts.php'>"  ;
			else:
				echo  "<a class='sidebar-brand d-flex align-items-center justify-content-center' href='index.php'>"  ;
			endif; ?>
			<div class="sidebar-brand-icon rotate-n-15">
				<i class="fas fa-laugh-wink"></i>
			</div>
			<?php if( $role == "user" ):
				echo "<div class='sidebar-brand-text mx-3'>USER  <sup> * </sup></div>" ;
			else:
				echo "<div class='sidebar-brand-text mx-3'>ADMIN  <sup> * </sup></div>" ;
			endif; ?>
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
						<!-- <a class="collapse-item" href="editUser.php">Update </a>
						<a class="collapse-item" href="deleteUser.php">Delete </a> -->
					</div>
				</div>
			</li>

			<!-- Nav Item - Utilities Collapse Menu -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="profile.php" data-toggle="collapse" data-target="#collapseUtilities"
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
					<form  method="GET"
						class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
						<div class="input-group">
							<input type="text" name="search_term" id="search_term" class="form-control bg-light border-0 small" placeholder="Search for..."
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
									<a class="dropdown-item" href="profile.php" >
										<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
										<input class="btn btn-white" type="submit" value="Profile" name="profile" >
									</a>

									<div class="dropdown-divider"></div>
									<form action="logout.php" method="post">
										<a class="dropdown-item"  >
											<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
											<input class="btn btn-white" type="submit" value="Logout" name="logout" >
										</a>
									</form>
								</div>
							</li>

				</nav>

		<!-- Begin Page Content -->

		<div class="container">

			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h2 class="mb-0"> Welcome, <?php echo $_SESSION['username']; ?> !! </h2>
				<a href="add_post.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
						class="fas fa-download fa-sm text-white-50"></i> Add Post </a>
			</div>

				<?php foreach ($resultPosts as $row): {
					echo "<div class='card-group'>" ;
					echo   "<div class='card row'>" ;
					echo   "<div class='card-body'> " ;
					echo   "<h3 class='card-title' style='float:left' >" .$row['title']. "</h3>" ;
					if ( $row['nb_report'] >= 2 and  $row['user_id'] != $user_id ):
						echo  "<div style='float:right' ><form method='POST' style='float:right' ><input  name='nb_report' class='btn btn-danger' type='submit' value='" .$row['nb_report']. "' > reports &nbsp; <input name='vote_type' type='hidden' value='report' > <input name='id' type='hidden' value='" .$row['id']. "' > </form></div>" ;
					endif ;
					if( $row['nb_report'] <= 1 and  $row['user_id'] != $user_id ):
						echo  "<div style='float:right' ><form method='POST' style='float:right'><input  name='nb_report' class='btn btn-success' type='submit' value='" .$row['nb_report']. "' > reports &nbsp; <input name='vote_type' type='hidden' value='report' > <input name='id' type='hidden' value='" .$row['id']. "' > </form></div>" ;
					endif ;
					echo   "<br><p class='card-text' style='float:left' > ".$row['desc']." </p>" ;
					if ( $row['user_id'] != $user_id ):
						echo   "<p class='card-text' style='float:left ;color:green' > Posted By : ".$row['username']."  </p><br><br>" ;
					else:
						echo   "<p class='card-text' style='float:left ;color:green' > Posted By : Me </p><br><br>" ;
					endif ;
					#if( $user_id == $row['user_id'] ): echo  "<td><a href=\"editPost.php?id=$row[id]\"><i class='fas fa-edit fa-sm fa-fw mr-2 text-green-600'></i></a> | <a href=\"deletePost.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\"><i class='fas fa-trash fa-sm fa-fw mr-2 text-red-600'></i></a></td>"; endif ;
					echo   "<br><br><td><form method='GET' ><input type='hidden' name='id' value=".$row['id']. "></form></td> "  ;
					echo  "<div class='row'  ><form method='POST' ><input  name='nb_like' class='btn btn-info' type='submit' value='" .$row['nb_like']. "' > <input  name='nb_dislike' class='btn btn-info' type='hidden' value='" .$row['nb_dislike']. "' ><i class='fa fa-thumbs-up fa-lg' aria-hidden='true'></i>  <input name='vote_type' type='hidden' value='like' > <input name='id' type='hidden' value='" .$row['id']. "' > </form> <span>   </span> <form method='POST' name='form2' ><input  name='nb_dislikee' class='btn btn-info' type='submit' value='" .$row['nb_dislike']. "' > <input  name='nb_likee' class='btn btn-info' type='hidden' value='" .$row['nb_like']. "' > <i class='fa fa-thumbs-down fa-lg' aria-hidden='true'></i> <input name='vote_type' type='hidden' value='dislike' > <input name='id' type='hidden' value='" .$row['id']. "' > </form></div>" ;
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

</body>
</html>


