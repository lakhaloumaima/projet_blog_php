
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
  $stmt = $dbConn->query("SELECT * FROM posts WHERE user_id = $id ");
  $resultPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

if ( !($id))  {
	header("Location: login.php");
}

if(isset($_POST['update']))
{
	$id = $_SESSION['id'] ;

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
		$sql = "UPDATE users SET username=:username, email=:email WHERE id=:id";
		$query = $dbConn->prepare($sql);

		$query->bindparam(':id', $id);
		$query->bindparam(':username', $username);
		$query->bindparam(':email', $email);
		$query->execute();

		// Alternative to above bindparam and execute
		// $query->execute(array(':id' => $id, ':name' => $name, ':email' => $email, ':age' => $age));

		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}

//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$sql = "SELECT * FROM users WHERE id=:id";
$query = $dbConn->prepare($sql);
$query->execute(array(':id' => $id));

while($row = $query->fetch(PDO::FETCH_ASSOC))
{
	$username = $row['username'];
	$email = $row['email'];
}

?>

<!DOCTYPE html>
<html>

<head>
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
    <style>
        body {
            background: rgb(99, 39, 120)
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .profile-button:hover {
            background: #682773
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 11px
        }

        h3 {
            color: black ;
        }
</style>

</head>

<body>

    <?php
        include_once( "sidebar.php" ) ;
    ?>

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column p-3 py-2">
                <img class="rounded-circle mt-5"
                    width="120px"
                    src="../img/logo.png"> <br>
                <h3 class="text-black-50"><?php echo $_SESSION['email']; ?> </h3><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <form  method="post" >
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels"> Username </label><input type="text" class="form-control" value="<?php echo $_SESSION['username']; ?>"></div>
                        <div class="col-md-6"><label class="labels"> Email </label><input type="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" ></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels"> Password </label>
                        <input type="password" class="form-control" placeholder="change your Password ..." >
                        </div>
                    </div>
                    <div class="mt-5 text-center"><button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" type="submit" name="update" >Save Profile</button></div>
                </form>
            </div>
        </div>

        <br>
        <!-- Begin Page Content -->

			<div class="container">

                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <a href="add_post.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Add Post </a>
                </div>

                <div class="card-group">
                    <?php foreach ($resultPosts as $row): {
                        echo "<div class='card'>" ;
                        echo   "<div class='card-body'> " ;
                        echo    "<h3 class='card-title'>" .$row['title']. "</h3>" ;
                        echo   " <p class='card-text'> ".$row['desc']." </p>" ;
                        echo "<td ><a href=\"editPost.php?id=$row[id]\"><i class='fas fa-edit fa-sm fa-fw mr-2 text-green-600'></i></a> | <a href=\"deletePost.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\"><i class='fas fa-trash fa-sm fa-fw mr-2 text-red-600'></i></a></td>";
                        echo" </div> " ;
                        echo" </div> " ;
                    }
                    endforeach; ?>

                </div>
            </div>

    </div>


</div>
</div>
</div>

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