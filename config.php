<?php

$hostDB = '127.0.0.1';
$nameDB = 'databaseProject';
$usernameDB = 'oumaima';
$passwordDB = '1234';

try {
	$dbConn = new PDO("mysql:host={$hostDB};dbname={$nameDB}", $usernameDB, $passwordDB);

	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Setting Error Mode as Exception

} catch(PDOException $e) {
	echo $e->getMessage();
}





?>
