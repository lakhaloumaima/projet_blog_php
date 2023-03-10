<?php
// Connect to the database
include_once("config.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    #$password = $_POST['password'] ;
   # $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Hash the password
    #$hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $stmt = $dbConn->prepare("INSERT INTO users ( email , username, password ) VALUES (:email , :username, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password );

    $stmt->execute();

    // Set the session variables
    $_SESSION['user_id'] = $dbConn->lastInsertId();

    echo "<font color='green'>Data added successfully.";
    echo "<br/><a href='login.php'>View Result</a>";

    // Redirect to the home page
    header('Location: login.php');
    #exit();
}
else {
    echo "<font color='red'>Data not added successfully.";
}
?>