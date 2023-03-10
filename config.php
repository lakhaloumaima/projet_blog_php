<?php

$hostDB = '127.0.0.1';
$nameDB = 'databaseProject';
$usernameDB = 'oumaima';
$passwordDB = '1234';

try {
	// http://php.net/manual/en/pdo.connections.php
	$dbConn = new PDO("mysql:host={$hostDB};dbname={$nameDB}", $usernameDB, $passwordDB);

	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Setting Error Mode as Exception
	// More on setAttribute: http://php.net/manual/en/pdo.setattribute.php
} catch(PDOException $e) {
	echo $e->getMessage();
}






?>
