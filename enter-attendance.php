<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php $_GET['mode']; ?></title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link href='https://fonts.googleapis.com/css?family=Baloo Da 2' rel='stylesheet'>
  <style media="screen">
    body {
      font-weight: 400;
      font-family: 'Baloo Da 2';
      font-size: 1.0rem;
    }

    .userdef {
      height: 1.5em;
      width: 1.5em;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand title" href="login.php">
      <h1><b>CSE-D</b> <span class="badge badge-secondary">Attendance</span></h1>
    </a>
  </nav>
  <br>
  <?php
  require 'dbactions.php';
  $subjectList = array("ca" => "Computer Organization Architecture", "ps" => "Probability Statistics", "ds" => "Data Structures", "cs" => "Communication Systems", "oops" => "Object Oriented Programming", "cie" => "Computer and Information Ethics", "ecs" => "Environmental Climate Science", "dsl" => "Data Structures Laboratory", "oopsl" => "Object Oriented Programming Laboratory", "ssa" => "Soft Skills and Aptitude - I", "verbal" => "Verbal", "ql" => "Quant and Logical");
  session_start();
  if ($_SESSION["loggedin"] != TRUE) {
    header("Location: login.php");
  }
  if ($_SESSION['time'] <= time()) {
    session_destroy();
    header("Location: login.php?expired=true");
  }
  $subject = $_GET['subject'];
  $date = $_GET['date'];
  $period = $_GET['period'];

  if (isset($_POST["back"])) {
    header("Location: dashboard.php");
    exit();
  }

  if (isset($_POST["submit"])) {
    unset($_POST["submit"]);
    updateAttendance($_POST, $date, $period, $subject);
  }
  ?>
  <section class="container-fluid">
    <section class="row justify-content-center">
      <section class="container-lg container-md container-sm">
        <form action="" method="post">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead class="thead-dark">
                <tr>
                  <?php
                  echo "<th scope='col' >Subject: " . $subjectList[$subject] . "</th><th scope='col' >Date : " . $date . " </th><th scope='col' >Period : " . $period . "</th>";
                  ?>
                </tr>
                <tr>
                  <th scope="col">Reg No<br><small id="helpId" class="text-muted">RegNo</small></th>
                  <th scope="col">Names<br><small id="helpId" class="text-muted">Names</small></th>
                  <th scope="col">Attendence <br> <small id="helpId" class="text-muted">Select All</small><input type="checkbox" name="" id="select-all"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($_GET["subject"])) {
                  getUpdatedEntry($date, $subject, $period);
                } else {
                  echo "<h1>Invalid Request !</h1>";
                }
                ?>
              </tbody>
            </table>
          </div>
          <div id="submit-attendace" style="text-align:center;">
            <button type="submit" id="backBtn" name="back" class="btn btn-secondary">Back</button>&nbsp&nbsp&nbsp&nbsp<button type="submit" name="submit" onclick="return confirm('Are you sure want to submit ?');" class="btn btn-primary">Submit</button>
          </div>
          <br>
          <hr>
        </form>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="bootstrap/js/bootstrap.min.js" charset="utf-8"></script>
        <script>
          $(document).ready(function() {
            $('#select-all').click(function() {
              var checked = this.checked;
              $('input[type="checkbox"]').each(function() {
                this.checked = checked;
              });
            })
          });
        </script>
        </div>
      </section>
    </section>
  </section>
</body>

</html>