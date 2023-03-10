<?php
//including the database connection file
include_once("config.php");

session_start();
$id = $_SESSION['user_id'];
//fetching data in descending order (lastest entry first)
$resultUsers = $dbConn->query("SELECT * FROM users ORDER BY id DESC");

	$resultUsers->execute(array(':id' => $id ) ) ;
	$user = $resultUsers->fetch();

# $resultUsers = $dbConn->query("SELECT * FROM posts ORDER BY id DESC");

if ( !($id))  {
	header("Location: login.php");
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

    <title> Dashboard </title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body>

<?php
 	include_once( "sidebar.php") ;
?>

			<!-- Begin Page Content -->
			<div class="container-fluid">

				<div class="d-sm-flex align-items-center justify-content-between mb-4">
					<h1 class="mb-0"> Welcome, <?php echo $_SESSION['username']; ?> !! </h1>
					<a href="add_user.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i	class="fas fa-download fa-sm text-white-50"></i> Add User </a>
				</div>

				<table width='100%' border=0 >

					<tr bgcolor='#CCCCCC'>
						<td> Name </td>
						<td> Email </td>
						<td> Actions </td>
					</tr>

					<?php
					while($row = $resultUsers->fetch(PDO::FETCH_ASSOC)) {
						echo "<tr>";
						echo "<td>".$row['username']."</td>";
						echo "<td>".$row['email']."</td>";
						echo "<td><a href=\"editUser.php?id=$row[id]\"><i class='fas fa-edit fa-sm fa-fw mr-2 text-green-600'></i></a> | <a href=\"deleteUser.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\"><i class='fas fa-trash fa-sm fa-fw mr-2 text-red-600'></i></a></td>";
					}
					?>
				</table>

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
