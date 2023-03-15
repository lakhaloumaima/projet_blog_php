<?php
// Connect to the database
include_once("config.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = md5($_POST['password']);

    $stmt = $dbConn->prepare("SELECT * FROM users WHERE email = ? ");
    $stmt->execute( [ $email ]);

    if ( $stmt ) {
        // Insert the user into the database
        $stmt = $dbConn->prepare("INSERT INTO users ( email , username , role , password ) VALUES (:email , :username, :role  , :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':password', $password );

        $stmt->execute();

        // Set the session variables
        $_SESSION['user_id'] = $dbConn->lastInsertId();

        echo "<font color='green'>Data added successfully.";
        echo "<br/><a href='login.php'>View Result</a>";

        // Redirect to the home page
        header('Location: login.php');
    }
    else {
        echo "<div  class='alert alert-danger' role='alert' > Email Exist !! </div> ";
    }
}
else {
    echo "<font color='red'>Data not added successfully.";
}
?>