<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <style media="screen">
    .form-container {
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px black;
      top: 25vh;
    }
  </style>
  <title>View Entry</title>
  <?php require "dbactions.php";
  session_start();
  if ($_SESSION["loggedin"] != TRUE) {
    header("Location: login.php");
  }
  if ($_SESSION['time'] <= time()) {
    session_destroy();
    header("Location: login.php?expired=true");
  }
  $date = $_GET["date"];
  $subject = $_GET["subject"];
  $period = $_GET["period"];
  $subjectList = array("ca" => "Computer Organization Architecture", "ps" => "Probability Statistics", "ds" => "Data Structures", "cs" => "Communication Systems", "oops" => "Object Oriented Programming", "cie" => "Computer and Information Ethics", "ecs" => "Environmental Climate Science", "dsl" => "Data Structures Laboratory", "oopsl" => "Object Oriented Programming Laboratory", "ssa" => "Soft Skills and Aptitude - I", "verbal" => "Verbal", "ql" => "Quant and Logical");
  ?>
  <?php
  if (isset($_POST["back"])) {
    header("Location: dashboard.php");
  }
  ?>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand title" href="login.php">
      <h1><b>CSE-D</b> <span class="badge badge-secondary">Attendance</span></h1>
    </a>
  </nav>
  <center>
    <br>
    <section class="container-fluid">
      <section class="row justify-content-center">
        <section class="container-lg container-md container-sm">
          <div class="table-responsive">
            <table class="table table-striped table-bordered" id="viewTable">
              <thead class="thead-dark">
                <tr>
                  <?php
                  echo "<th scope='col' >Subject: " . $subjectList[$subject] . "</th><th scope='col' >Date : " . str_replace("_", "-", $date) . " </th><th scope='col' >Period : " . $period . "</th>";
                  ?>
                </tr>
                <tr>
                  <th scope="col">Reg No<br><small id="helpId" class="text-muted">RegNo</small></th>
                  <th scope="col">Names<br><small id="helpId" class="text-muted">Names</small></th>
                  <th scope="col">Attendence <br> <small id="helpId" class="text-muted">Present / Absent</small></th>
                </tr>
              </thead>
              <tbody>
                <?php
                getEntry($date, $subject, $period);
                ?>

              </tbody>
            </table>
            <br>
            <center>
              <div id="btnsCont">
                <form action="" method="post"><button type="submit" name="back" id="backBtn" class="btn btn-secondary">Back</button>&nbsp&nbsp&nbsp&nbsp<button type="button" id="printBtn" class="btn btn-info">Print</button></form>
              </div>
            </center>
            <br>
            <hr>
          </div>
        </section>
      </section>
    </section>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.min.js" charset="utf-8"></script>
    <script type="text/javascript">
      $("#printBtn").click(function() {
        document.getElementById("btnsCont").style.display = "none";
        window.print();
        document.getElementById("btnsCont").style.display = "block";

      });

      var absent_arr = document.getElementsByClassName("btn-danger");
      var present_arr = document.getElementsByClassName("btn-success");
      var table = document.getElementById("viewTable");
      var present = present_arr.length;
      var absent = absent_arr.length;
      var total = absent + present;
      var percentage = ((present / total) * 100);
      var row = table.insertRow(total + 2);

      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);

      cell1.innerHTML = "<h4>Total : " + total + "</h4>";
      cell2.innerHTML = "<h4>Absentees : " + absent + "</h4>";
      cell3.innerHTML = "<h4>Attendance : " + percentage.toFixed(2) + "%" + "</h4>";

      console.log(absent);
      console.log(present);
      console.log(percentage);
    </script>
</body>

</html>