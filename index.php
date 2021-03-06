<?php
  require_once("core/init.php");
  $user = new User();

  if (!$user->isLoggedIn()) {
    Redirect::redirectTo("login.php");
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Backend</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Simple-Backend</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Profile</a></li>
            <li><a href="#">Messages <span class="badge">42</span></a></li>
            <li><a href="#">Help</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-cog"></span></a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right mobile">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Analytics</a></li>
          </ul>
          <p class="navbar-text navbar-right">
          	<?= htmlentities($user->data()->name) ?>
          </p>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 side-mobile">
          <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
              <li><a href="#">Dashboard</a></li>
              <li class="active"><a href="#">Gallery</a></li>
              <li><a href="#">Analytics</a></li>
            </ul>
          </div>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <?php
          if (Session::exists("home")) {
            echo "<div class='alert alert-success alert-dismissible' role='alert'>";
            echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>";
            echo Session::flash("home");
            echo "</div>";
          }
          ?>

          <ol class="breadcrumb">
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Add new Gallery</a></li>
            <li class="active">Add new photo</li>
          </ol>
          <div class="page-header">
            <h1>Dashboard</h1>
            <?php
            if ($user->hasPermission("admin")) {
              echo "<p>You are an Administrator!</p>";
            }
            else {
              echo "<p>" . htmlentities($user->data()->name) . ", you are logged in!</p>";
            }
            ?>
          </div>

          <h2 class="sub-header">Actions</h2>

            <ul>
              <li><a href="update_user.php">Update Information</a></li>
              <li><a href="upload.php">Upload file</a></li>
              <li><a href="register.php">Register new user</a></li>
            </ul>
          
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Header</th>
                  <th>Header</th>
                  <th>Header</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1,001</td>
                  <td>Lorem</td>
                  <td>dolor</td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <button class="btn btn-info">Info</button>
                      <button class="btn btn-warning">Edit</button>
                      <button class="btn btn-danger">Remove</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>1,002</td>
                  <td>amet</td>
                  <td>consectetur</td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <button class="btn btn-info">Info</button>
                      <button class="btn btn-warning">Edit</button>
                      <button class="btn btn-danger">Remove</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>1,003</td>
                  <td>Integer</td>
                  <td>odio</td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <button class="btn btn-info">Info</button>
                      <button class="btn btn-warning">Edit</button>
                      <button class="btn btn-danger">Remove</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>1,003</td>
                  <td>libero</td>
                  <td>cursus</td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <button class="btn btn-info">Info</button>
                      <button class="btn btn-warning">Edit</button>
                      <button class="btn btn-danger">Remove</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>1,004</td>
                  <td>dapibus</td>
                  <td>Sed</td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <button class="btn btn-info">Info</button>
                      <button class="btn btn-warning">Edit</button>
                      <button class="btn btn-danger">Remove</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Blabla</td>
                  <td>Nulla</td>
                  <td>sem</td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <button class="btn btn-info">Info</button>
                      <button class="btn disabled btn-warning">Edit</button>
                      <button class="btn btn-danger">Remove</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <h2 class="sub-header">Section title</h2>
          <p>Add more content</p>
          <form role="form" action="self">
            <div class="form-group has-error">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
              <p class="help-block">Example block-level help text here.</p>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="exampleInputFile">File input</label>
              <input type="file" id="exampleInputFile">
              <p class="help-block">Example block-level help text here.</p>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox"> Check me out
              </label>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
        </div>
      </div>
    </div>




    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>