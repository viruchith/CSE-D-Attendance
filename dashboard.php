<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link href='https://fonts.googleapis.com/css?family=Baloo Da 2' rel='stylesheet'>
  <title>Dashboard</title>
  <style media="screen">
    body {
      font-weight: 400;
      font-family: 'Baloo Da 2';
      font-size: 22px;

    }

    .form-container {
      padding: 70px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px black;
      top: 25vh;
    }

    @media screen and (min-device-width: 1200px) and (max-device-width: 1600px) and (-webkit-min-device-pixel-ratio: 1) {
      .form-container {
        margin: 10%;
      }

    }

    /*.contBox {
      background-color: white;
      width: 80%;
      border: 8px solid #1c1c1c;
      padding: 50px;
      margin: 10%;
      border-radius: 10px;
    }*/


    #searchResult {
      text-decoration: none;
      color: black;
      width: 80%;

    }

    #searchBar {
      width: 80%;
    }

    #titleText {
      bottom: 25px;
    }

    .error {
      color: red;
    }
  </style>
  <?php
  require 'dbactions.php';
  session_start();
  if ($_SESSION["loggedin"] != TRUE) {
    header("Location: login.php");
  }
  if ($_SESSION['time'] <= time()) {
    session_destroy();
    header("Location: login.php?expired=true");
  }
  if (isset($_POST["logout"])) {
    // destroy the session
    session_unset();
    session_destroy();
    header("Location: login.php");
  }

  if (isset($_POST["namelist"])) {
    header("Location: namelist.php");
  }
  ?>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand title" href="login.php">
      <h1><b>CSE-D</b> <span class="badge badge-secondary">Attendance</span></h1>
    </a>
  </nav>
  <?php
  if (isset($_POST["create"])) {
    $date = $_POST["date"];
    $period = $_POST["period"];
    $subject = $_POST["subject"];
    $create = createEntry($subject, $date, $period);
    if ($create == TRUE) {
      header("Location: enter-attendance.php?subject=" . $subject . "&date=" . $date . "&period=" . $period . "&mode=NewEntry");
    }
  }
  ?>
  <?php
  if (isset($_POST["proceed"])) {
    $date = $_POST["update-date"];
    $period = $_POST["update-period"];
    $subject = $_POST["update-subject"];
    $update = updateEntry($subject, $date, $period);
    if ($update == TRUE) {
      header("Location: enter-attendance.php?subject=" . $subject . "&date=" . $date . "&period=" . $period . "&mode=UpdateEntry");
    } else {
      echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Entry Does not exist !</div></div></center>";
    }
  }
  ?>

  <?php
  if (isset($_POST["view-entry"])) {
    $date = $_POST["view-entry-date"];
    $period = $_POST["view-entry-period"];
    $entryExists = entryExists($date, $period);
    $subjectlist = array("ca" => "ca", "ps" => "ps", "cie" => "cie", "ds" => "ds", "dsl" => "dsl", "cs" => "cs", "ecs" => "ecs", "oops" => "oops", "oopsl" => "oopsl", "ssa" => "ssa", "verbal" => "verbal", "ql" => "ql");
    $subject = $entryExists;
    if (isset($subjectlist[$subject])) {
      header("Location: view-entry.php?subject=" . $subject . "&date=" . $date . "&period=" . $period);
    } else {
      echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Entry Does not exist !</div></div></center>";
    }
  }
  ?>

  <?php
  if (isset($_POST["add-mem"])) {
    $name = $_POST["member-name"];
    $regno = $_POST["member-regno"];
    addMember($regno, $name);
  }
  ?>

  <?php
  if (isset($_POST["delete-mem"])) {
    $name = $_POST["member-name"];
    $regno = $_POST["member-regno"];
    deleteMember($regno, $name);
  }
  ?>
  <?php
  if (isset($_POST["update-regno"])) {
    $name = $_POST["member-name"];
    $regno = $_POST["member-regno"];
    updateRegNo($regno, $name);
  }
  ?>
  <?php
  if (isset($_POST["create-user"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $usercreatemsg = createUser($username, $password);
    if (strcmp($usercreatemsg, "success") == 0) {
      echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-success' role='alert'>'$username' was created successfully ! </div></div></center>";
    } else {
      echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>'$usercreatemsg'</div></div></center>";
    }
  }

  ?>
  <center>
    <br>
    <section class="container-fluid">
      <section class="row justify-content-center">
        <section class="container-lg container-md container-sm">
          <div class="form-container" id="optionbar">
            <br>
            <div style="text-align:right;font-size:20px;"><button type="button" id="entryPop" class="btn btn-secondary" data-container="body" data-toggle="popover" data-html="true" data-placement="bottom" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">📝</button></div>
            <br>
            <input type="text" placeholder="Search by name..." onkeyup="showResult(this.value);" aria-describedby="basic-addon1" id="searchBar">
            <div id="searchResult" style="border:10px;"></div>
            <br>
            <br>
            <button type="button" class="btn btn-outline-success btn-lg btn-block" id="newEntryBtn">Create New Entry</button><br>
            <button type="button" class="btn btn-outline-primary btn-lg btn-block" id="updateBtn">Udate an Entry</button><br>
            <button type="button" class="btn btn-outline-secondary btn-lg btn-block" id="viewEntryBtn">View an Entry</button><br>
            <button type="button" class="btn btn-outline-warning btn-lg btn-block" id="memberAddDel">Add / Delete Member</button><br>
            <button type="button" class="btn btn-outline-primary btn-lg btn-block" id="userAddBtn">Add User</button><br>

            <form class="" method="post">
              <button type="submit" name="namelist" class="btn btn-outline-info btn-lg btn-block">Namelist</button><br>
            </form>
            <form class="" method="post">
              <button type="submit" name="logout" class="btn btn-outline-danger btn-lg btn-block">Logout</button><br>
            </form>
          </div>
  </center>
  <div class="" style="display:none;" id="createNew">
    <form method="post" class="form-container">
      <div style="text-align:center;content-align:center;">
        <h1>Create New Entry</h1>
        <div class="form-group">
          <label for="date">Choose Date</label>
          <center> <input type="date" name="date" id="" style="font-size:1.2rem;width:30vh;text-align:center;" class="form-control" placeholder="" aria-describedby="helpId" required></center>
        </div>
        <div class="form-group">
          <label for="period">Choose period :</label>
          <select name="period" id="" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </div>
        <div class="form-group">
          <label for="subject">Choose subject : </label>
          <select name="subject" id="" required>
            <option value="ca">Computer Architecture</option>
            <option value="ps">Probability and Statistics</option>
            <option value="cie">Computer Information and Ethics</option>
            <option value="ds">Data Structure</option>
            <option value="dsl">Data Structure ( Laboratory )</option>
            <option value="cs">Communication Systems</option>
            <option value="ecs">Environmental and Climate Science</option>
            <option value="oops">Object Oriented Programming</option>
            <option value="oopsl">Object Oriented Programming( Laboratory )</option>
            <option value="ssa">Soft Skills and Aptitude</option>
            <option value="verbal">Verbal</option>
            <option value="ql">Quant & Logical</option>
          </select>
        </div>
        <div id="submit-attendace" style="text-align:center;">
          <button type="button" name="back" id="createBackBtn" class="btn btn-secondary">Back</button>&nbsp&nbsp&nbsp&nbsp<button type="submit" name="create" onclick="return confirm('Do you want to create this entry ?');" class="btn btn-primary">Create</button>
        </div>
      </div>
    </form>
  </div>
  <div class="" id="update" style="display:none;">
    <form method="post" class="form-container">
      <div style="text-align:center;content-align:center;top-margin:30%;bottom:20px;">
        <h1>Update Entry</h1>
        <div class="form-group">
          <label for="update-date">Choose Date</label>
          <center> <input type="date" name="update-date" id="" style="font-size:1.2rem;width:180px;text-align:center;" class="form-control" placeholder="" aria-describedby="helpId" required></center>
        </div>
        <div class="form-group">
          <label for="update-period">Choose period :</label>
          <select name="update-period" id="" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </div>
        <div class="form-group">
          <label for="update-subject">Choose subject : </label>
          <select name="update-subject" id="" required>
            <option value="ca">Computer Architecture</option>
            <option value="ps">Probability and Statistics</option>
            <option value="cie">Computer Information and Ethics</option>
            <option value="ds">Data Structure</option>
            <option value="dsl">Data Structure( Laboratory )</option>
            <option value="cs">Communication Systems</option>
            <option value="ecs">Environmental and Climate Science</option>
            <option value="oops">Object Oriented Programming</option>
            <option value="oopsl">Object Oriented Programming( Laboratory ) </option>
            <option value="ssa">Soft Skills and Aptitude</option>
            <option value="verbal">Verbal</option>
            <option value="ql">Quant and Logical</option>
          </select>
        </div>
        <div id="submit-attendace" style="text-align:center;">
          <button type="button" name="backBtn" id="updateBackBtn" class="btn btn-secondary">Back</button>&nbsp&nbsp&nbsp&nbsp<button type="submit" name="proceed" onclick="return confirm('Are you sure want to update ?');" class="btn btn-primary">Proceed</button>
        </div>
      </div>
    </form>
  </div>


  <div class="" id="viewEntry" style="display:none;">
    <form method="post" class="form-container">
      <div style="text-align:center;">
        <h1>View Entry</h1>
        <div class="form-group">
          <label for="view-entry-date">Choose Date</label>
          <center> <input type="date" name="view-entry-date" id="" style="font-size:1.2rem;width:180px;text-align:center;" class="form-control" placeholder="" aria-describedby="helpId" required></center>
        </div>
        <div class="form-group">
          <label for="view-entry-period">Choose period :</label>
          <select name="view-entry-period" id="" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </div>
        <div id="submit-attendace" style="text-align:center;">
          <button type="button" name="backBtn" id="viewBackBtn" class="btn btn-secondary">Back</button>&nbsp&nbsp&nbsp&nbsp<button type="submit" name="view-entry" class="btn btn-primary">Proceed</button>
        </div>
      </div>
    </form>
  </div>



  <div class="form-container" id="add-delete" style="display:none;">
    <form method="post">
      <div style="text-align:center;content-align:center;top-margin:30%;bottom:20px;">
        <h1>Add or Delete Member</h1>
        <div class="form-group">
          <label for="member-name">RegNo : </label>
          <center> <input type="text" name="member-regno" id="" style="font-size:1.2rem;width:180px;text-align:center;" class="form-control" placeholder="" aria-describedby="helpId" required></center>
        </div>
        <div class="form-group">
          <label for="member-name">Name :</label>
          <center> <input type="text" name="member-name" id="" style="font-size:1.2rem;width:180px;text-align:center;" class="form-control" placeholder="" aria-describedby="helpId" required> </center>
        </div>
        <div id="submit-attendace" style="text-align:center;">
          <button type="button" name="" id="addOrDelBackBtn" class="btn btn-secondary">Back</button>&nbsp&nbsp&nbsp&nbsp<button type="submit" name="add-mem" onclick="return confirm('Are you sure want to add this member ?');" class="btn btn-primary">Add</button>&nbsp&nbsp&nbsp&nbsp<button type="submit" name="delete-mem" onclick="return confirm('Are you sure want to delete this member ?');" class="btn btn-danger">Delete</button>&nbsp&nbsp&nbsp&nbsp<button type="submit" name="update-regno" onclick="return confirm('Are you sure want to update RegNo ?');" class="btn btn-warning">Update Reg</button>
        </div>
      </div>
    </form>
  </div>

  <div class="form-container" id="userAdd" style="display:none;">
    <center>
      <form method="post" id="userForm">
        <div class="form-group">
          <label for="exampleInputEmail1">Username</label>
          <input type="text" name="username" style="width:45%;" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="password" style="width:45%;" class="form-control" id="exampleInputPassword1">
        </div>
        <center><button type="button" name="back" id="userAddBackBtn" class="btn btn-secondary">Back</button>&nbsp&nbsp&nbsp&nbsp<button type="submit" name="create-user" class="btn btn-primary">Add</button></center>
      </form>
    </center>
  </div>

  </section>
  </section>
  </section>
  <br>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="bootstrap/popper.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js" charset="utf-8"></script>
  <script src="jquery-validation/dist/jquery.validate.js"></script>
  <script src="jquery-validation/dist/additional-methods.js"></script>
  <script>
    $("#userForm").validate({
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
  <script type="text/javascript">
    $("#newEntryBtn").click(function() {
      document.getElementById('optionbar').style.display = "none";
      document.getElementById('createNew').style.display = "block";
      document.getElementById('update').style.display = "none";
      document.getElementById('userAdd').style.display = "none";
      document.getElementById('viewEntry').style.display = "none";
      document.getElementById('add-delete').style.display = "none";
    });
    $("#updateBtn").click(function() {
      document.getElementById('optionbar').style.display = "none";
      document.getElementById('update').style.display = "block";
      document.getElementById('userAdd').style.display = "none";
      document.getElementById('createNew').style.display = "none";
      document.getElementById('viewEntry').style.display = "none";
      document.getElementById('add-delete').style.display = "none";
    });
    $("#viewEntryBtn").click(function() {
      document.getElementById('optionbar').style.display = "none";
      document.getElementById('update').style.display = "none";
      document.getElementById('userAdd').style.display = "none";
      document.getElementById('createNew').style.display = "none";
      document.getElementById('viewEntry').style.display = "block";
      document.getElementById('add-delete').style.display = "none";
    });
    $("#memberAddDel").click(function() {
      document.getElementById('userAdd').style.display = "none";
      document.getElementById('optionbar').style.display = "none";
      document.getElementById('update').style.display = "none";
      document.getElementById('createNew').style.display = "none";
      document.getElementById('viewEntry').style.display = "none";
      document.getElementById('add-delete').style.display = "block";
    });
    $("#createBackBtn").click(function() {
      document.getElementById('optionbar').style.display = "block";
      document.getElementById('update').style.display = "none";
      document.getElementById('userAdd').style.display = "none";
      document.getElementById('createNew').style.display = "none";
      document.getElementById('viewEntry').style.display = "none";
      document.getElementById('add-delete').style.display = "none";
    });
    $("#updateBackBtn").click(function() {
      document.getElementById('optionbar').style.display = "block";
      document.getElementById('update').style.display = "none";
      document.getElementById('userAdd').style.display = "none";
      document.getElementById('createNew').style.display = "none";
      document.getElementById('viewEntry').style.display = "none";
      document.getElementById('add-delete').style.display = "none";
    });
    $("#viewBackBtn").click(function() {
      document.getElementById('optionbar').style.display = "block";
      document.getElementById('update').style.display = "none";
      document.getElementById('userAdd').style.display = "none";
      document.getElementById('createNew').style.display = "none";
      document.getElementById('viewEntry').style.display = "none";
      document.getElementById('add-delete').style.display = "none";
    });
    $("#addOrDelBackBtn").click(function() {
      document.getElementById('optionbar').style.display = "block";
      document.getElementById('userAdd').style.display = "none";
      document.getElementById('update').style.display = "none";
      document.getElementById('createNew').style.display = "none";
      document.getElementById('viewEntry').style.display = "none";
      document.getElementById('add-delete').style.display = "none";
    });
    $("#userAddBtn").click(function() {
      document.getElementById('userAdd').style.display = "block";
      document.getElementById('optionbar').style.display = "none";
      document.getElementById('update').style.display = "none";
      document.getElementById('createNew').style.display = "none";
      document.getElementById('viewEntry').style.display = "none";
      document.getElementById('add-delete').style.display = "none";
    });
    $("#userAddBackBtn").click(function() {
      document.getElementById('userAdd').style.display = "none";
      document.getElementById('optionbar').style.display = "block";
      document.getElementById('update').style.display = "none";
      document.getElementById('createNew').style.display = "none";
      document.getElementById('viewEntry').style.display = "none";
      document.getElementById('add-delete').style.display = "none";
    });

    $(function() {
      $('[data-toggle="popover"]').popover()
    })

    $('#entryPop').popover().click(function() {
      setTimeout(function() {
        $('#entryPop').popover('hide');
      }, 2500);
    });
    //
    function addZero(i) {
      if ((i / 10) < 1) {
        i = "0" + i.toString();
      }
      return i;
    }

    function fetchTodayStatus() {
      var d = new Date();
      var year = d.getFullYear();
      var month = addZero(d.getMonth() + 1);
      var day = addZero(d.getDate());
      var dt = year + "-" + month + "-" + day;
      console.log(dt);
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var resp = "<strong><u>Today : " + day + "/" + month + "/" + year + "</u></strong><br><br>";
          resp += this.responseText;
          document.getElementById("entryPop").setAttribute("data-content", resp);
        }
      };
      xmlhttp.open("GET", "response.php?date=" + dt, true);
      xmlhttp.send();
    }
    fetchTodayStatus();

    function showResult(name) {
      if (name.length == 0) {
        document.getElementById("searchResult").innerHTML = "";
        document.getElementById("searchResult").style.border = "0px";
        return;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("searchResult").innerHTML = this.responseText;
          document.getElementById("searchResult").style.border = "1px solid #A5ACB2";
        }
      }
      xmlhttp.open("GET", "response.php?name=" + name, true);
      console.log(name);
      xmlhttp.send();
    }
  </script>
</body>

</html>