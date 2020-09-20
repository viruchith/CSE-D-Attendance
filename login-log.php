<?php
require 'dbactions.php';

session_start();
if (strcmp('admin',$_SESSION['user']) != 0) {
    header("Location: login.php");
}
$sql = "SELECT DISTINCT username,ip,time,sno FROM login_log ORDER BY sno DESC LIMIT 50 ";
$result = mysqli_query($connection, $sql);
if (!$result) {
    echo mysqli_error($connection);
    exit();
}
$response = "";
$count = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $response .= "<tr><td>".$count."</td><td>".$row['username']."</td><td>".$row['ip']."</td><td>".$row['time']."</td></tr>";
    $count++;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <tr>
        <th>Sno</th>
        <th>Username</th>
        <th>IP</th>
        <th>Time</th>
        </tr>
        <?php echo $response ?>
    </table>
</body>

</html>