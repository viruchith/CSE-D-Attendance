<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    }

?>

<?php 
require "dbactions.php";
if (isset($_GET["date"])) {
$response=getTodayStatus($_GET["date"]);
echo $response;
}
?>
<?php 
if (isset($_GET["name"])) {
$response=getStudentByName($_GET["name"]);
echo $response;
}
?>
