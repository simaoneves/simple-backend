<?php
require_once("core/init.php");

$user = new User();

if ($user->isLoggedIn()) {
	Redirect::redirectTo("index.php");
}

if (!empty($_POST)) {
	if (Token::check(Input::get("token"))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
				'username' => array(
					'required' => true
				),
				'password' => array(
					'required' => true,
				),
			));
		if ($validation->passed()) {
			$user = new User();
			$remember = (Input::get("remember") === "on") ? true : false;
			$login = $user->login(Input::get("username"), Input::get("password"), $remember);

			if ($login) {
				Redirect::redirectTo("index.php");
			}
			else {
				echo "Login failed";	
			}
		}
		else {
			foreach ($validation->errors() as $error) {
				echo $error . "<br>";
			}
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Backend Sign-in</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <form class="form-signin" role="form" method="post" action="login.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="username" class="form-control" name="username" placeholder="Username" value="<?= htmlentities(Input::get('username')); ?>" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="remember"> Remember me
          </label>
        </div>
        <input type="hidden" name="token" value="<?= Token::generate(); ?>">
        <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
