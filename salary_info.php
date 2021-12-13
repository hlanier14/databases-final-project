<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<body>

<!-- connect to database -->
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




<!-- get user input title to find company with highest salary -->
<br>>
<p>Find out which company has the highest salary for the title: </p>
<!-- use user input title in query and output result -->
<?php
$title_query = mysqli_query($conn, "Select distinct title from Salary;") or die (mysqli_error($conn));
echo "<form action='' method='POST'>";
echo "<select name='company_max_salary_title' onchange='this.form.submit()'>";
while ($row = mysqli_fetch_array($title_query)) {
   echo "<option value='" . $row['title'] . "'>" . $row['title'] . "</option>";
}
echo "</select>";
echo "</form>";
?>

<?php
$company_max_salary_title = htmlentities($_POST['company_max_salary_title']);
$sal_query = mysqli_query($conn, "Select company, total_yearly_compensation
                                 From Salary
                                 Where title = \"$company_max_salary_title\"
                                 And total_yearly_compensation = 
                                 (select max(total_yearly_compensation) from Salary where title = \"$company_max_salary_title\");")
or die (mysqli_error($conn));
// Output row of query, should only be one row for this question
while ($row = mysqli_fetch_array($sal_query)) {
  echo "<p>{$row['company']} pays a {$company_max_salary_title} employee a total compensation of $ {$row['total_yearly_compensation']}</p>";
}
?>



<!-- get user input title to find the average entry level salary -->
<br>
<p>Find out the average entry level salary for the title: </p>
<form action="" method="get">
        <input type="text" name="avg_entry_salary_title" id="avg_entry_salary_title"></input>
</form>
<!-- use user input title for query -->
<?php
$avg_entry_salary_title = htmlentities($_GET['avg_entry_salary_title']);
$query = mysqli_query($conn, "Select avg(total_yearly_compensation) as avg
		   	      From Salary
			      Where title = \"$avg_entry_salary_title\"
			      And years_of_experience = 0;")
			      or die (mysqli_error($conn));
while ($row = mysqli_fetch_array($query)) {
   echo "<p>{$row['avg']}</p>";
}
?>






</table>
</body>
</html>

