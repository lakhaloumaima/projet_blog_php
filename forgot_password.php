<?php
include_once("config.php");

session_start();

// define function to verify hashed password
function verifyPassword($oldPassword, $hashed_password) {
    return md5($oldPassword) === $hashed_password;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = $_POST['email'];
    $oldPassword = $_POST['password'] ;
    $newPassword = md5($_POST['newPassword']);

	// checking empty fields
	if(empty($email)  || empty($oldPassword) || empty($newPassword)  ) {

		if(empty($email)) {
			echo "<font color='red'> Email field is empty.</font><br/>";
		}
        if(empty($oldPassword)) {
			echo "<font color='red'>Old Password field is empty.</font><br/>";
		}

		// if(empty($password)) {
		// 	echo "<font color='red'>Password field is empty.</font><br/>";
		// }
        if(empty($newPassword)) {
			echo "<font color='red'> New Password field is empty.</font><br/>";
		}

		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else {
		// if all the fields are filled (not empty)
        $stmt = $dbConn->prepare("SELECT * FROM users WHERE email = ? ");
        $stmt->execute([ $email ]);
        $user = $stmt->fetch();

        if ($user && verifyPassword($oldPassword, $user['password']) ) {
            //updating the table
            $stmt = $dbConn->prepare("UPDATE users SET `password` = :password  WHERE email = :email");
            $stmt->execute(array(':password' => $newPassword, ':email' => $email  ));

            // Check if the update was successful
            if ($stmt->rowCount() > 0) {
                header("Location: login.php");
            }

	    }
        else {
            echo "<div  class='alert alert-danger' role='alert' > Email Not Exist !! </div> ";
        }
    }
}

?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Yinka Enoch Adedokun">
	<meta name="description" content="Simple Forgot Password Page Using HTML and CSS">
	<meta name="keywords" content="forgot password page, basic html and css">
	<title>Forgot Password Page - HTML + CSS</title>

    <style>
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "segoe ui", verdana, helvetica, arial, sans-serif;
        font-size: 16px;
        transition: all 500ms ease; }

        body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
        -moz-font-feature-settings: "liga" on; }

        .row {
        background-color: rgba(20, 120, 200, 0.6);
        color: #fff;
        text-align: center;
        padding: 2em 2em 0.5em;
        width: 90%;
        margin: 2em	auto;
        border-radius: 5px; }
        .row h1 {
            font-size: 2.5em; }
        .row .form-group {
            margin: 0.5em 0; }
            .row .form-group label {
        display: block;
        color: #fff;
        text-align: left;
        font-weight: 600; }
        .row .form-group input, .row .form-group button {
        display: block;
        padding: 0.5em 0;
        width: 100%;
        margin-top: 1em;
        margin-bottom: 0.5em;
        background-color: inherit;
        border: none;
        border-bottom: 1px solid #555;
        color: #eee; }
        .row .form-group input:focus, .row .form-group button:focus {
            background-color: #fff;
            color: #000;
            border: none;
            padding: 1em 0.5em; animation: pulse 1s infinite ease;}
        .row .form-group button {
        border: 1px solid #fff;
        border-radius: 5px;
        outline: none;
        -moz-user-select: none;
        user-select: none;
        color: #333;
        font-weight: 800;
        cursor: pointer;
        margin-top: 2em;
        padding: 1em; }
        .row .form-group button:hover, .row .form-group button:focus {
            background-color: #fff; }
        .row .form-group button.is-loading::after {
            animation: spinner 500ms infinite linear;
            content: "";
            position: absolute;
            margin-left: 2em;
            border: 2px solid #000;
            border-radius: 100%;
            border-right-color: transparent;
            border-left-color: transparent;
            height: 1em;
            width: 4%; }
        .row .footer h5 {
            margin-top: 1em; }
        .row .footer p {
            margin-top: 2em; }
            .row .footer p .symbols {
            color: #444; }
        .row .footer a {
            color: inherit;
            text-decoration: none; }

        .information-text {
        color: #ddd; }

        @media screen and (max-width: 320px) {
        .row {
            padding-left: 1em;
            padding-right: 1em; }
            .row h1 {
            font-size: 1.5em !important; } }
        @media screen and (min-width: 900px) {
        .row {
            width: 50%; } }

    </style>
</head>
<body>
	<div class="row">
		<h1>Forgot Password</h1>
		<h6 class="information-text">Enter your registered email to reset your password.</h6>
        <form method="POST"   >
            <div class="form-group">
            <p><label for="username">Email</label></p>
                <input type="email" name="email" id="email">
                <p><label for="username">password</label></p>
                <input type="password" name="password" id="password">
                <p><label for="username">newPassword</label></p>
                <input type="password" name="newPassword" id="newPassword">
                <button type="submit" >Reset Password</button>
            </div>
        </form>
		<div class="footer">
			<h5>New here? <a href="register.php">Sign Up.</a></h5>
			<h5>Already have an account? <a href="login.php">Sign In.</a></h5>
		</div>
	</div>
</body>


</html>