<?php
  /* Connect to the database. */
  include_once('php/database_connect.php');

  /* If the user is not logged in, redirect to the login page. */
  if (!isUserLoggedIn())
    header('Location: loginUser.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="User Dashboard">
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Custom -->
    <link rel="stylesheet" href="css/global.css">
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  </head>

  <body>

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Passes for Passes</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Settings</a></li>
            <li><a href="#">Help</a></li>
            <li><a href="logout.php">Log Out</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <!-- Recently Requested Passes -->
          <ul class="nav nav-sidebar">
            <li class="active"><a href=""><b>Your Recently Requested Passes</b></a></li>
            <?php
              $RequestedQuery = "SELECT * FROM Exchange_history WHERE requesterNetId='{$_SESSION['user']['netId']}' ORDER BY requestPassDate DESC LIMIT 5;";
              $RequestedResult = mysql_query($RequestedQuery);
              if ($RequestedResult) {
                if (mysql_num_rows($RequestedResult) == 0)
                  echo "<li><a><i>0 records found.</i></a></li>";
                else {
                  for ($i = 0; $i < mysql_num_rows($RequestedResult); $i++) {
                    $row = mysql_fetch_assoc($RequestedResult);
                    $reqDate = date('m-d-Y', strtotime($row['requestPassDate']));
                    echo '<li><a href="#">' . $reqDate . ': ' . $row['requestPassType'] . '</a></li>';
                  }
                }
              }
            ?>
          </ul>
          <!-- Recently Offered Passes -->
          <ul class="nav nav-sidebar">
            <li><a href=""><b>Your Recently Offered Passes</b></a></li>
            <?php
              $RequestedQuery = "SELECT * FROM Exchange_history WHERE providerNetId='{$_SESSION['user']['netId']}' ORDER BY requestPassDate DESC LIMIT 5;";
              $RequestedResult = mysql_query($RequestedQuery);
              if ($RequestedResult) {
                if (mysql_num_rows($RequestedResult) == 0)
                  echo "<li><a><i>0 records found.</i></a></li>";
                else {
                  for ($i = 0; $i < mysql_num_rows($RequestedResult); $i++) {
                    $row = mysql_fetch_assoc($RequestedResult);
                    $reqDate = date('m-d-Y', strtotime($row['requestPassDate']));
                    echo '<li><a href="#">' . $reqDate . ': ' . $row['requestPassType'] . '</a></li>';
                  }
                }
              }
            ?>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Welcome <?php echo $_SESSION['user']['firstName']; ?>!</h1>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>

</html>
