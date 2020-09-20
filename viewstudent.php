<?php
require "dbactions.php";
session_start();

if ($_SESSION["loggedin"] != TRUE) {
    header("Location: login.php");
}
if ($_SESSION['time'] <= time()) {
    session_destroy();
    header("Location: login.php?expired=true");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Baloo Da 2' rel='stylesheet'>
    <title>View Student Progress </title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand title" href="login.php">
            <h1><b>CSE-D</b> <span class="badge badge-secondary">Attendance</span></h1>
        </a>
    </nav>
    <section class="container-fluid">
        <section class="row justify-content-center">
            <section class="container-lg container-md container-sm">

                <?php
                if (isset($_GET["regno"])) {
                    $response = getStudentDetails($_GET["regno"]);
                    echo $response;
                }
                ?>
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
                <script src="bootstrap/popper.min.js"></script>
                <script src="bootstrap/js/bootstrap.min.js" charset="utf-8"></script>
            </section>
        </section>
    </section>

</body>

</html>