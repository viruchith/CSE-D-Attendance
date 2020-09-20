<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

  <title>Name List</title>
  <?php require "dbactions.php";
  session_start();
  if ($_SESSION["loggedin"] != TRUE) {
    header("Location: login.php");
  }
  if ($_SESSION['time'] <= time()) {
    session_destroy();
    header("Location: login.php?expired=true");
  }
  if (isset($_POST["back"])) {
    header("Location: dashboard.php");
    exit();
  }

  ?>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand title" href="login.php">
      <h1><b>CSE-D</b> <span class="badge badge-secondary">Attendance</span></h1>
    </a>
  </nav>
  <br>
  <section class="container-fluid">
    <section class="row justify-content-center">
      <section class="container-lg container-md container-sm">
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Reg No<br><small id="helpId" class="text-muted">RegNo</small></th>
                <th scope="col">Names<br><small id="helpId" class="text-muted">Names</small></th>
              </tr>
            </thead>
            <tbody>
              <?php
              getNamelist();
              ?>
            </tbody>
          </table>
          <br>
          <form action="" method="post">
            <center>
              <div id="btnsCont"><button type="submit" name="back" id="backBtn" class="btn btn-secondary">Back</button>&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" id="printBtn" class="btn btn-info">Print</button></div>
            </center>
          </form>
        </div>
      </section>
    </section>
  </section>
  <br>
  <hr>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script type="text/javascript">
    $("#printBtn").click(function() {
      document.getElementById("btnsCont").style.display = "none";
      window.print();
      document.getElementById("btnsCont").style.display = "block";
    });
  </script>
</body>

</html>