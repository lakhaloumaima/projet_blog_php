<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
 crossorigin="anonymous">
 <style>
      body {
	background:url(background.jpg) no-repeat center center fixed ;
	-webkit-background-size:cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	background-size:cover;
}
      </style>
    <title>Inscription</title>
</head>
<body>


<div class="row">
    <div class="col-md-6 col-md-offset-3" id="login">

        <form class="box" action="register_action.php" method="POST">
            <center>
                <img src="../img/logo.png"  style="width:15%" >

                <h1 class="box-title">S'inscrire</h1>
            </center>

            <div class="form-group">
                <label class="idn">Email : </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required >
                    </div>
            </div>

            <div class="form-group">
                <label class="idn">Username : </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required >
                    </div>
            </div>
            <div class="form-group">
                    <div class="input-group">
                        <input type="hidden" class="form-control" id="role" name="role" placeholder="Enter role" value="user" >
                    </div>
            </div>

            <div class="form-group">
                <label class="idn">Password : </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required >
                    </div>
            </div>
            <div class="form-group">
                <button type="submit" name="Submit" class="btn btn-primary">Register</button>
            </div>
            <p class="box-register">have aaccount ? <a href="login.php"> Login </a></p>
        </form>

</body>
</html>