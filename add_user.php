<html>
<head>
	<title>Add Data</title>
</head>

<body>

	<?php
	include_once( "sidebar.php" ) ;
	?>

	<div class="container" >
		<a href="index.php"> Back to Dashboard </a>
		<br/><br/>

		<form action="add_user_action.php" method="post" name="form1">

				<tr>
					<td>Name</td>
					<td><input type="text" class="form-control" name="username"></td>
				</tr>
				<br>
				<tr>
					<td>Email</td>
					<td><input type="text" class="form-control" name="email"></td>
				</tr>
				<br>
				<tr>
					<td>Password</td>
					<td><input type="password" class="form-control" name="password"></td>
				</tr>
				<br>
				<tr>
					<td></td>
					<td><input type="submit" name="Submit" value="Add" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" ></td>
				</tr>

		</form>
	</div>

</body>
</html>
