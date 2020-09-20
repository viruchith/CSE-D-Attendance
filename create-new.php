<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  </head>
  <body>
  <?php
  require 'dbactions.php';
  ?>
<form action="create-new.php" method="post">
<br><br><br><br>
<?php
  if (isset($_POST["create"])) {
      $date= $_POST["date"];
      $period=$_POST["period"];
      $subject=$_POST["subject"];
      $create=createEntry($subject,$date,$period);
      if ($create==TRUE) {
          header("Location: enter-attendance.php?subject=".$subject."&date=".$date."&period=".$period);
      }

  }
  ?>
<div style="text-align:center;content-align:center;top-margin:30%;bottom:20px;" >
<div class="form-group">
  <label for="">Choose Date</label>
  <center> <input type="date" name="date" id="" style="font-size:1.2rem;width:180px;text-align:center;" class="form-control" placeholder="" aria-describedby="helpId" required ></center>
</div>
<div class="form-group">
  <label for="">Choose period :</label>
    <select name="period" id="" required >
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    </select>
</div>
<div class="form-group">
  <label for="">Choose subject : </label>
    <select name="subject" id="" required >
    <option value="coa">COA</option>
    <option value="ps">PS</option>
    <option value="cie">CIE</option>
    <option value="ds">DS</option>
    <option value="dsl">DS(L)</option>
    <option value="cs">CS</option>
    <option value="ecs">ECS</option>
    <option value="oops">OOPS</option>
    <option value="oopsl">OOPS(L)</option>
    <option value="ssa">SSA</option>
    <option value="verbal">VERBAL</option>
    <option value="ql">Q&L</option>
    </select>
</div>
<div id="submit-attendace" style="text-align:center;">
<button type="submit" name="create" class="btn btn-primary">Create</button>
</div>
</div>
</form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>
