<?php
	include_once("config.php");
	session_start();

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// unset($_SESSION['user_id']);
			// unset($_SESSION['email']);
			// unset($_SESSION['username']);
			session_unset();
			session_destroy();
			header('Location: login.php');

	}


?>