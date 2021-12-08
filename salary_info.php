<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "DBFall2021*";
$db = "salary";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

<table border="1" align="center">
<tr>
  <td>city_id</td>
  <td>location</td>
</tr>

<?php

$query = mysqli_query($conn, "SELECT * FROM Location")
   or die (mysqli_error($conn));

while ($row = mysqli_fetch_array($query)) {
  echo
   "<tr>
    <td>{$row['city_id']}</td>
    <td>{$row['location']}</td>
   </tr>";
}

?>

</table>
</body>
</html>

