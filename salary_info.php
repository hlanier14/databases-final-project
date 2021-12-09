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
  <td>company</td>
</tr>
<form action="" method="get">
<input type="text" name="title" id="title"></input>
</form>

<?php
$title = htmlentities($_GET['title']);
$query = mysqli_query($conn, "Select company
                              From Salary
                              Where title = \"$title\"
                              And total_yearly_compensation = 
                              (select max(total_yearly_compensation) from Salary where title = \"$title\");")
or die (mysqli_error($conn));

while ($row = mysqli_fetch_array($query)) {
  echo
   "<tr>
    <td>{$row['company']}</td>
   </tr>";
}

?>

</table>
</body>
</html>

