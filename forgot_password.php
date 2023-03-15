<?php
include_once("config.php");

session_start();


function forgotPassword($email) {
    // check if email exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        // email not found in the database
        return false;
    }

    // generate a new password
    $newPassword = generatePassword();

    // update the user's password in the database
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([password_hash($newPassword, PASSWORD_DEFAULT), $user['id']]);

    // send the new password to the user's email
    $subject = "New Password";
    $message = "Your new password is: " . $newPassword;
    $headers = "From: webmaster@example.com\r\n";
    $headers .= "Content-type: text/html\r\n";
    mail($email, $subject, $message, $headers);

    return true;
}

function generatePassword() {
    // generate a random password of 8 characters
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = "";
    for ($i = 0; $i < 8; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
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
		<div class="form-group">
			<input type="email" name="user_email" id="user_email">
			<p><label for="username">Email</label></p>
			<button onclick="showSpinner()">Reset Password</button>
		</div>
		<div class="footer">
			<h5>New here? <a href="#">Sign Up.</a></h5>
			<h5>Already have an account? <a href="#">Sign In.</a></h5>
			<p class="information-text"><span class="symbols" title="Lots of love from me to YOU!">&hearts; </span><a href="https://www.facebook.com/adedokunyinka.enoch" target="_blank" title="Connect with me on Facebook">Yinka Enoch Adedokun</a></p>
		</div>
	</div>
</body>


</html>