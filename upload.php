<?php
  require_once 'core/init.php';

  // if form was submited
  if (!empty($_POST)) {

    // check if token is correct
    if (Token::check(Input::get('token'))) {
      $file = new FileUpload();

      // if some file was/were uploaded
      if ($file->exists()) {

        // if there were no upload errors
        if (!$file->error()) {

          // if the file was moved successfully
          if ($file->moveTo()) {
            Session::flash("home", "You successfully uploaded a file!");
            Redirect::redirectTo("index.php");
          }
        }
        else {
          echo $file->getErrorMsg();
        }
      }
      else {
        echo "No file";
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
            nome
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
          <ol class="breadcrumb">
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Add new Gallery</a></li>
            <li class="active">Add new photo</li>
          </ol>
          <div class="page-header">
            <h1>Upload file</h1>
            <p>Texto</p>
          </div>
           <form role="form" action="upload.php" enctype="multipart/form-data" method="post">
            <div class="form-group">
			  <label for="exampleInputFile">File input</label>
			  <input type="file" name="file_upload" id="exampleInputFile">
			</div>
            <input type="hidden" name="token" value="<?= Token::generate(); ?>">
            <button type="submit" name="submit" class="btn btn-default">Upload</button>
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