<?php
if (isset($_GET['expired'])) {
  echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Session Expired !</div></div></center>";
}
?>

<?php
session_start();
if (isset($_SESSION['loggedin'])) {
  header("Location: dashboard.php");
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link href='https://fonts.googleapis.com/css?family=Baloo Da 2' rel='stylesheet'>
  <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">-->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <style media="screen">
    body {
      font-weight: 400;
      font-family: 'Baloo Da 2';
      font-size: 22px;
    }

    .form-container {
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px black;
      position: absolute;
      top: 20vh;
    }

    .error {
      color: red;
    }
  </style>
  <title>Login</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand title" href="login.php">
      <h1><b>CSE-D</b> <span class="badge badge-secondary">Attendance</span></h1>
    </a>
  </nav>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="bootstrap/popper.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js" charset="utf-8"></script>
  <script src="jquery-validation/dist/jquery.validate.js"></script>
  <script src="jquery-validation/dist/additional-methods.js"></script>
  <?php
  require 'dbactions.php';
  if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (login($username, $password, $_SERVER['REMOTE_ADDR']) == TRUE) {
      $_SESSION["user"] = $username;
      $_SESSION["loggedin"] = TRUE;
      $_SESSION["time"] = time() + 3600;
      header("Location: dashboard.php");
    }
  }
  ?>
  <section class="container-fluid">
    <section class="row justify-content-center">
      <section class="col-12 col-sm-6 col-md-3 ">
        <form method="post" class="form-container" id="loginForm">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
          </div>
          <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
      </section>
    </section>
  </section>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->

  <script>
    $("#loginForm").validate({
      rules: {
        username: {
          required: true,
          rangelength: [4, 50]
        },
        password: {
          required: true,
          rangelength: [4, 50]
        }
      },
      messages: {
        username: {
          required: "You cannot leave the username empty !",
          rangelength: "Your username must be between 4 and 50 characters"
        },
        password: {
          required: "You cannot leave the password empty !",
          rangelength: "Your password must be between 4 and 50 characters"
        }
      }
    });
  </script>
</body>

</html>