<?php
require 'time.php';
$connection = mysqli_connect("conn");
if($connection) {
    //echo "<h1>Connected</h1>";
}else {
    echo "<h1>DB not Connected</h1>";
}

function getTodayStatus($date){
global $connection;
$query = "SELECT * FROM attendance_entry_log WHERE date = '$date'";
$result=mysqli_query($connection,$query);
$response ="";

$period_array = array("<h5>Not entered</h5>","<h5>Not entered</h5>","<h5>Not entered</h5>","<h5>Not entered</h5>","<h5>Not entered</h5>");

$count = 0;

while ($row = mysqli_fetch_assoc($result)) {
  if ($row['date'] == $date ) {
   $period_array[$count] = "<div style='color:green;'>Entered<div>";
   $count++;
}
}
return "Period 1 : ".$period_array[0]."<br>"."Period 2 : ".$period_array[1]."<br>"."Period 3 : ".$period_array[2]."<br>"."Period 4 : ".$period_array[3]."<br>"."Period 5 : ".$period_array[4];
}

if (isset($_GET["date"])) {
getTodayStatus($_GET["date"]);
}

function createEntry($subj,$date,$period){
global $connection;
    $subjectlist=array("ca"=>"ca","ps"=>"ps","cie"=>"cie","ds"=>"ds","dsl"=>"dsl","cs"=>"cs","ecs"=>"ecs","oops"=>"oops","oopsl"=>"oopsl","ssa"=>"ssa","verbal"=>"verbal","ql"=>"ql");
    if (!isset($subjectlist[$subj])) {
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Invalid Subject Name !</div></div></center>";
    return FALSE;
    }
    $sql = "SELECT * FROM attendance_entry_log WHERE date ='$date' AND period = '$period'";
    $result=mysqli_query($connection,$sql);
    $row=mysqli_fetch_assoc($result);
    if(isset($row["period"])){
        echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Entry already exists !</div></div></center>";
        return FALSE;
    }else {
        $sql_insert="INSERT INTO attendance_entry_log (date,period,subject) VALUES ('$date','$period','$subj')";
        mysqli_query($connection,$sql_insert);
        $sql_select = "SELECT * FROM student_primary";
        $result=mysqli_query($connection,$sql_select);
        while ($row = mysqli_fetch_assoc($result)) {
          $sql_insert_2 = "INSERT INTO ".$subj." (reg_no,name,date,period) VALUES('$row[reg_no]','$row[name]','$date','$period') ";
          mysqli_query($connection,$sql_insert_2);
        }
        echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-success' role='alert'>Entry created successfully !</div></div></center>";
        return TRUE;
    }
}
/*function entryDisplay(){
global $connection;
$sql = "SELECT reg_no,name FROM student_primary ";
$result=mysqli_query($connection,$sql);
while ($row=mysqli_fetch_assoc($result)) {
echo "<tr><td>".$row['reg_no']."</td><td>".$row['name']."</td>"."<td><input type ='checkbox' class='userdef' name='$row[reg_no]'  value='present' id='att'></td></tr>";
}
}
*/
function updateAttendance($attendance,$date,$period,$subject){
global $connection;

$date=mysqli_real_escape_string($connection,$date);
$period=mysqli_real_escape_string($connection,$period);
$subject=mysqli_real_escape_string($connection,$subject);

$subjectlist=array("ca"=>"ca","ps"=>"ps","cie"=>"cie","ds"=>"ds","dsl"=>"dsl","cs"=>"cs","ecs"=>"ecs","oops"=>"oops","oopsl"=>"oopsl","ssa"=>"ssa","verbal"=>"verbal","ql"=>"ql");
if (isset($subjectlist[$subject])) {
    $subject=$subjectlist[$subject];
}else{
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Invalid Subject Name !</div></div></center>";
    return False;
}
$sql = "SELECT reg_no FROM student_primary ";
$result=mysqli_query($connection,$sql);
$final=array();
while($row=mysqli_fetch_assoc($result)){
if (isset($attendance[$row["reg_no"]])) {
    $final[$row["reg_no"]]="present";
} else {
    $final[$row["reg_no"]]="absent";

}
}
foreach($final as $regno=>$value){

$sql="UPDATE ".$subject." SET attendance ='$value'  WHERE reg_no ='$regno' AND date = '$date' AND period = '$period' ";
$result=mysqli_query($connection,$sql);

}
if ($result) {
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-success' role='alert'>Attendace updated successfully !</div></div></center>";
    return TRUE;
} else {
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Erro updating attendance !</div></div></center>";
    return FALSE;

}

}

function updateEntry($subj,$date,$period){
  global $connection;
  $subjectlist=array("ca"=>"ca","ps"=>"ps","cie"=>"cie","ds"=>"ds","dsl"=>"dsl","cs"=>"cs","ecs"=>"ecs","oops"=>"oops","oopsl"=>"oopsl","ssa"=>"ssa","verbal"=>"verbal","ql"=>"ql");
  if (!isset($subjectlist[$subj])) {
  echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Invalid Subject Name !</div></div></center>";
  return FALSE;
  }
  $sql = "SELECT * FROM attendance_entry_log WHERE date = '$date' AND subject = '$subj' AND period = '$period'";
  $result=mysqli_query($connection,$sql);
  $row=mysqli_fetch_assoc($result);
  if (isset($row["date"])) {
    if ($row['subject']==$subj and $row['period'] = $period) {
      return TRUE;
    } else {
    return FALSE;
    }

  } else {
    //echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Invalid Subject Name !</div></div></center>";
    return FALSE;
  }

}



function getEntry($date,$subj,$period){
  global $connection;
  $date=mysqli_real_escape_string($connection,$date);
  $subj=mysqli_real_escape_string($connection,$subj);
  $period=mysqli_real_escape_string($connection,$period);


  $pora=array("absent"=>"<button type='button' class='btn btn-danger'>Absent</button>","present"=>"<button type='button' class='btn btn-success'>Present</button");
  $subjectlist=array("ca"=>"ca","ps"=>"ps","cie"=>"cie","ds"=>"ds","dsl"=>"dsl","cs"=>"cs","ecs"=>"ecs","oops"=>"oops","oopsl"=>"oopsl","ssa"=>"ssa","verbal"=>"verbal","ql"=>"ql");
  if (!isset($subjectlist[$subj])) {
  echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Invalid Subject Name !</div></div></center>";
  return FALSE;
  }

$sql="SELECT reg_no,name,attendance FROM ".$subj." WHERE date = '$date' AND period = '$period' ORDER BY name";
$result=mysqli_query($connection,$sql);
while ($row=mysqli_fetch_assoc($result)) {
echo "<tr><td>".$row['reg_no']."</td><td>".$row['name']."</td>"."<td>".$pora[$row['attendance']]."</td></tr>";

}
}

function getUpdatedEntry($date,$subj,$period){
  global $connection;
$date=mysqli_real_escape_string($connection,$date);
$subj=mysqli_real_escape_string($connection,$subj);
$period=mysqli_real_escape_string($connection,$period);

  $subjectlist=array("ca"=>"ca","ps"=>"ps","cie"=>"cie","ds"=>"ds","dsl"=>"dsl","cs"=>"cs","ecs"=>"ecs","oops"=>"oops","oopsl"=>"oopsl","ssa"=>"ssa","verbal"=>"verbal","ql"=>"ql");
  if (!isset($subjectlist[$subj])) {
  echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Invalid Subject Name !</div></div></center>";
  return FALSE;
  }

$sql="SELECT * FROM ".$subj." WHERE date='$date' AND period = '$period' ORDER BY name";
$result=mysqli_query($connection,$sql);
while ($row=mysqli_fetch_assoc($result)) {
if ($row['attendance']=='absent') {
  echo "<tr><td>".$row['reg_no']."</td><td>".$row['name']."</td>"."<td><input type ='checkbox' class='userdef' name='$row[reg_no]'  value='present' id='att'></td></tr>";
} else {
  echo "<tr><td>".$row['reg_no']."</td><td>".$row['name']."</td>"."<td><input type ='checkbox' class='userdef' name='$row[reg_no]' checked  value='present' id='att'></td></tr>";
}


}
}

function entryExists($date,$period){
global $connection;
$sql = "SELECT date,period,subject FROM attendance_entry_log WHERE date = '$date' AND period = '$period'";
$result=mysqli_query($connection,$sql);
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    return $row["subject"];
  }
}else {
  return FALSE;
}

}

function login($username,$password,$ip){
global $connection;
$time = getDateTime();
$username=mysqli_real_escape_string($connection,$username);
$password=mysqli_real_escape_string($connection,$password);
  $sql="SELECT username,password FROM credentials WHERE username='$username'";
  $result=mysqli_query($connection,$sql);
  $row=mysqli_fetch_assoc($result);
  if (isset($row['username'])) {
      if (password_verify($password,$row['password'])) {
      $sql = "INSERT INTO login_log (username,time,ip) VALUES('$username','$time','$ip') ";
      $result = mysqli_query($connection, $sql);
        return TRUE;
      } else {
        echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Invalid password !</div></div></center>";
      }

  } else {
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'>Invalid username !</div></div></center>";
  }

}


function getNameList(){
  global $connection;
  $sql="SELECT reg_no,name FROM student_primary ORDER BY name";
  $result=mysqli_query($connection,$sql);
  while ($row=mysqli_fetch_assoc($result)) {
  echo "<tr><td>".$row['reg_no']."</td><td>".$row['name']."</td></tr>";

  }
}

function addMember($regno,$name){
  global $connection;
  $regno=mysqli_real_escape_string($connection,$regno);
  $name=mysqli_real_escape_string($connection,$name);
  $sql="INSERT INTO student_primary (reg_no,name) VALUES('$regno','$name') ";
  $result=mysqli_query($connection,$sql);
if($result){
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-success' role='alert'> '$name' was added Sucessfully !</div></div></center>";
}else{
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'> '$regno' already exists !  !</div></div></center>";

}

}

function deleteMember($regno,$name){
global $connection;
  $regno=mysqli_real_escape_string($connection,$regno);
  $name=mysqli_real_escape_string($connection,$name);
  $sql="DELETE FROM student_primary WHERE reg_no = '$regno' AND name = '$name'  ";
  $result=mysqli_query($connection,$sql);
if($result){
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-success' role='alert'> '$name' was Deleted Sucessfully !</div></div></center>";
}else{
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'> '$regno' does not exist !  !</div></div></center>";

}
}

function updateRegNo($regno,$name){
global $connection;
  $regno=mysqli_real_escape_string($connection,$regno);
  $name=mysqli_real_escape_string($connection,$name);
  $sql="UPDATE student_primary SET reg_no='$regno' WHERE name = '$name'  ";
  $result=mysqli_query($connection,$sql);
if($result){
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-success' role='alert'> '$regno' was updated successfully for '$name' !</div></div></center>";
}else{
    echo "<center><div style='content-align:center;text-align:center;width:300px;'><div class='alert alert-danger' role='alert'> '$name' is  not a valid name !  !</div></div></center>";

}
  
}


function getStudentByName($name){
  global $connection;
  $name=mysqli_real_escape_string($connection,$name);
  $query = "SELECT reg_no,name FROM student_primary";
  $result = mysqli_query($connection,$query);
  $response="";
  while ($row = mysqli_fetch_assoc($result)) {
    if (stristr($row["name"],$name)) {
      $href="/Attendance/viewstudent.php?regno="."$row[reg_no]";
      $response.="<a href='$href' target='_blank' rel='noopener noreferrer'>".$row["name"]."</a><hr>";
    }
  }
  return $response;
}

function getStudentDetails($regno){
  global $connection;
  $regno=mysqli_real_escape_string($connection,$regno);
  $tablelist=array("ca","ps","cie","ds","dsl","cs","ecs","oops","oopsl","ssa","verbal","ql");
  $subjectList=array("ca"=>"Computer Organization Architecture","ps"=>"Probability Statistics","ds"=>"Data Structures","cs"=>"Communication Systems","oops"=>"Object Oriented Programming","cie"=>"Computer and Information Ethics","ecs"=>"Environmental Climate Science","dsl"=>"Data Structures Laboratory","oopsl"=>"Object Oriented Programming Laboratory","ssa"=>"Soft Skills and Aptitude - I","verbal"=>"Verbal","ql"=>"Quant and Logical");
  $response = "";
  $overall =0;
  $query = "SELECT name FROM student_primary WHERE reg_no = '$regno'";
  $result = mysqli_query($connection,$query);
  while($row_1 = mysqli_fetch_assoc($result)){
  $response.="<hr><center><h1>Name : ".$row_1['name']."</h1><h1>RegNo : ".$regno."</h1></center><br><hr>";
  }
  foreach ($tablelist as $table) {
    $total = 0;
    $response.="<h1><u>".$subjectList[$table]."</u></h1><br><div class='table-responsive' ><table class = 'table'><thead class = 'thead-dark'><tr><th scope='column' >Date : </th><th scope='column' >Period</th></tr></thead><tbody>";
    $sql = "SELECT * FROM ".$table." WHERE reg_no = '$regno' AND attendance = 'absent' ";
    $result = mysqli_query($connection,$sql);
    while ($row = mysqli_fetch_assoc($result)) {
      $response.="<tr scope='row'><td>".$row["date"]."</td><td>".$row["period"]."</td></tr>";
      $total++;
      $overall++;
    }
    $response.="<tr scope='row' ><td><h5 style='color:red;'>Total : </h5></td><td><h5 style='color:red;' >".$total." hours</h5></td></tr>";
    $response.="</tbody></table></div><hr>";
  }
$response.="<hr><center><h1 style='color:red;' >Overall Absent : ".$overall." hours</h1></center><hr>";
return $response;
}

function createUser($username,$password){
  global $connection;
  $username = mysqli_escape_string($connection,$username);
  $password = mysqli_escape_string($connection, $password);

  $sql = "SELECT * FROM credentials ";
  $result = mysqli_query($connection,$sql);
  while($row = mysqli_fetch_assoc($result)){
    if (strcmp($row['username'],$username) == 0) {
      return "User already exists !";
    }
  }
  $password = password_hash($password,PASSWORD_BCRYPT);
  $sql = "INSERT INTO credentials (username,password) VALUES ('$username','$password')";
  $result = mysqli_query($connection, $sql);
  if ($result) {
    return "success";
  }else{
    return "user creation failed !";
  }


}

?>
