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
	
// Get distinct table of titles in Salary table
$dist_titles = mysqli_query($conn, "Select distinct title from Salary;")
?>




<!-- get user input title to find company with highest salary -->
<br>
<p>Find out which company has the highest salary for the title: </p>

<form action="" method="get">
<select id="title" name="title">
	<?php
	    while($row_list = mysql_fetch_assoc($dist_titles)){  
	?>  
	    <option value="<? echo $row_list['title']; ?>"<? if($row_list['title']==$select){ echo "selected"; } ?>>  
				 <?echo $row_list['title'];?>  
	    </option>  
	<?  
	}  
	?>  
</select>
<input type="submit" value="Submit" name="company_max_salary_title" id="company_max_salary_title">
</form>
<!-- use user input title in query and output result -->
<?php
$company_max_salary_title = htmlentities($_GET['company_max_salary_title']);
$query = mysqli_query($conn, "Select company
                              From Salary
                              Where title = \"$company_max_salary_title\"
                              And total_yearly_compensation = 
                              (select max(total_yearly_compensation) from Salary where title = \"$company_max_salary_title\");")
			      or die (mysqli_error($conn));
// Output row of query, should only be one row for this question
while ($row = mysqli_fetch_array($query)) {
  echo "<p>{$row['company']}</p>";
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

