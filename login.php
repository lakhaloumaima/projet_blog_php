
<?php
include_once("config.php");

session_start();

// define function to verify hashed password
function verifyPassword($password, $hashed_password) {
    return md5($password) === $hashed_password;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // prepare SQL statement to retrieve user by username
    $stmt = $dbConn->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(array(':email' => $email));
    $user = $stmt->fetch();

    // verify password
    if ($user && verifyPassword($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['username'] = $user['username'];

        header('Location: index_posts.php');
        exit;
    }
    else {
        $error = 'Invalid Email or Password';
        # echo "<div  class='alert alert-danger' role='alert' > Invalid Email or Password !! </div> ";
    }

}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">

</head>

<body>

<div class="row">
    <div class="col-md-6 col-md-offset-3" id="login">

        <form class="box" action="" method="POST">
            <center>
                <img src="../img/logo.png"  style="width:15%" >
                <h1 class="box-title">Se connecter</h1>
            </center>

            <div class="form-group">
                <label for="email"> Email: </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrer identifiant">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe: </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Entrer mot de passe">
                </div>
            </div>
            <br>
            <div class="alert alert-danger" role="alert">
                <?php if (isset($error)): ?>
                    <div><?php echo $error; ?></div>
                <?php endif; ?>
            </div>
            <br>
            <div class="form-check">
        <input class="form-check-input" type="checkbox" id="autoSizingCheck2">
        <label class="form-check-label" for="autoSizingCheck2">
          Remember me
        </label>
      </div>
            <div class="form-group">
                <button type="submit" name="Submit" class="btn btn-primary">Connexion</button>
            </div>
            <p class="box-register"> <a href="forgot_password.php">  Forgot password ? </a></p>
            <p class="box-register">Vous êtes nouveau ici? <a href="register.php">S'inscrire</a></p>

        </form>


    </div>
</div>
</body>

</html>