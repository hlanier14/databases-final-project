<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<body>

<head>	
<style>
	td {text-align: center;}
	tr:nth-child(even) {background-color: #D3D3D3}
	table, th, td {padding: 10px; border: 1px solid black; border-collapse: collapse;}
</style>
</head>
	
	
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
<br>



<center> <h1>User Input Questions</h1> </center>




<!-- get user input title to find company with highest salary -->
<br>
<h2>Find out which company has the highest salary for the title: </h2>
<!-- use user input title in query and output result -->
<?php
$title_query = mysqli_query($conn, "Select distinct title from Salary;") or die (mysqli_error($conn));
echo "<form action='' method='POST'>";
echo "<select name='company_max_salary_title' onchange='this.form.submit()'>";
// set default select to Select
echo "<option selected='selected' value='select'>Select</option>";
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
                                 (select max(total_yearly_compensation) from Salary where title = \"$company_max_salary_title\")
				 LIMIT 1;")
				 or die (mysqli_error($conn));
// Output row of query, should only be one row for this question
while ($row = mysqli_fetch_array($sal_query)) {
  echo "<p>{$row['company']} pays a {$company_max_salary_title} employee a total compensation of $ {$row['total_yearly_compensation']}</p>";
}
?>

	
	

<!-- get user input title to find company with lowest salary -->
<br>
<h2>Find out which company has the lowest salary for the title: </h2>
<!-- use user input title in query and output result -->
<?php
$title_query = mysqli_query($conn, "Select distinct title from Salary;") or die (mysqli_error($conn));
echo "<form action='' method='POST'>";
echo "<select name='company_min_salary_title' onchange='this.form.submit()'>";
// set default select to Select
echo "<option selected='selected' value='select'>Select</option>";
while ($row = mysqli_fetch_array($title_query)) {
   echo "<option value='" . $row['title'] . "'>" . $row['title'] . "</option>";
}
echo "</select>";
echo "</form>";
?>
<?php
$company_min_salary_title = htmlentities($_POST['company_min_salary_title']);
$sal_query = mysqli_query($conn, "Select company, total_yearly_compensation
	                          From Salary
	                          Where title = \"$company_min_salary_title\"
	                          And total_yearly_compensation =
				  (select min(total_yearly_compensation) from Salary where title = \"$company_min_salary_title\")
				  LIMIT 1;")
			       	  or die (mysqli_error($conn));
// Output row of query, should only be one row for this question
while ($row = mysqli_fetch_array($sal_query)) {
   echo "<p>{$row['company']} pays a {$company_min_salary_title} employee a total compensation of $ {$row['total_yearly_compensation']}</p>";
}
?>




<!-- get user input title to find the average entry level salary -->
<br>
<h2>Find out the average entry level salary for the title:</h2>
<!-- use user input title in query and output result -->
<?php
$title_query = mysqli_query($conn, "Select distinct title from Salary;") or die (mysqli_error($conn));
echo "<form action='' method='POST'>";
echo "<select name='avg_entry_salary_title' onchange='this.form.submit()'>";
// set default select to Select
echo "<option selected='selected' value='select'>Select</option>";
while ($row = mysqli_fetch_array($title_query)) {
   echo "<option value='" . $row['title'] . "'>" . $row['title'] . "</option>";
}
echo "</select>";
echo "</form>";
?>
<!-- use user input title for query -->
<?php
$avg_entry_salary_title = htmlentities($_POST['avg_entry_salary_title']);
$entry_lvl_query = mysqli_query($conn, "Select round(avg(total_yearly_compensation)) as avg
		   	      From Salary
			      Where title = \"$avg_entry_salary_title\"
			      And years_of_experience = 0
			      LIMIT 1;")
or die (mysqli_error($conn));
echo "{$entry_lvl_query}";
while ($row = mysqli_fetch_array($entry_lvl_query)) {
   echo "<p>An entry level {$avg_entry_salary_title} employee makes on average $ {$row['avg']}</p>";
}
?>





<!-- get user input title to find the education levels for a given title -->
<br>
<h2>Find out the percentage of employees have a bachelors, masters and doctorate for:</h2>
<!-- use user input title in query and output result -->
<?php
$title_query = mysqli_query($conn, "Select distinct title from Salary;") or die (mysqli_error($conn));
echo "<form action='' method='POST'>";
echo "<select name='ed_title' onchange='this.form.submit()'>";
// set default select to Select
echo "<option selected='selected' value='select'>Select</option>";
while ($row = mysqli_fetch_array($title_query)) {
   echo "<option value='" . $row['title'] . "'>" . $row['title'] . "</option>";
}
echo "</select>";
echo "</form>";
?>
<!-- use user input title for query -->
<?php
$ed_title = htmlentities($_POST['ed_title']);
$ed_query = mysqli_query($conn, "SELECT X.*
				FROM
				(SELECT 'bachelors' as degree, sum(bachelors)/COUNT(bachelors)*100 AS percent
				FROM Salary WHERE title = \"$ed_title\" UNION
				SELECT 'masters' as degree, sum(masters)/COUNT(masters)*100 as percent FROM Salary
				WHERE title = \"$ed_title\" UNION
				SELECT 'doctorate' as degree, sum(doctorate)/COUNT(doctorate)*100 AS percent FROM Salary
				WHERE title = \"$ed_title\") as X
				ORDER BY X.percent desc;")
				or die (mysqli_error($conn));
echo "{$ed_title}";
echo "<table> <tr> <th>Education</th> <th>Percent</th> </tr>";
while($row = mysqli_fetch_array($ed_query)) {
   echo "<tr> <td>{$row['degree']}</td> <td>{$row['percent']}</td> </tr>";
}
echo "</table>";
?>



<!-- find average salaries for managers and non-managers at given company -->
<br>
<h2>Find out the average manager and non-manager salaries at company:</h2>
<!-- use user input title in query and output result -->
<?php
$company_query = mysqli_query($conn, "Select distinct company from Salary;") or die (mysqli_error($conn));
echo "<form action='' method='POST'>";
echo "<select name='m_vs_nm_company' onchange='this.form.submit()'>";
// set default select to Select
echo "<option selected='selected' value='select'>Select</option>";
while ($row = mysqli_fetch_array($company_query)) {
   echo "<option value='" . $row['company'] . "'>" . $row['company'] . "</option>";
}
echo "</select>";
echo "</form>";
?>
<!-- use user input title for query -->
<?php
$m_vs_nm_company = htmlentities($_POST['m_vs_nm_company']);
$m_vs_nm_query = mysqli_query($conn, "select 'manager' as titlestr, round(avg(total_yearly_compensation)) as avg from Salary
	where title like '%manager%'
	and company = \"$m_vs_nm_company\" UNION
	select 'non-manager' as titlestr, round(avg(total_yearly_compensation)) as avg from Salary
	where title not like '%manager%' and company = \"$m_vs_nm_company\";") or die (mysqli_error($conn));
echo "{$m_vs_nm_company}";
echo "<table> <tr> <th>Position</th> <th>Avg Salary</th> </tr>";
while($row = mysqli_fetch_array($m_vs_nm_query)) {
   echo "<tr> <td>{$row['titlestr']}</td> <td>{$row['avg']}</td> </tr>";
}
echo "</table>";
?>







<!-- find the average compensation at each company for a given amount of work experience -->
<br>
<h2>Which companies pay the highest compensation for an employee with ___ years of work experience?</h2>
<form action='' method='POST'>
<input type="number" name="experience_yrs">
<input type="submit">
</form>
<?php
$exp_yrs = htmlentities($_POST["experience_yrs"]);
$exp_query = mysqli_query($conn, "Select *, round(avg(total_yearly_compensation)) as Average
				  From Salary 
				  Where years_of_experience = \"$exp_yrs\"
				  Group by company
				  Order by Average DESC
				  LIMIT 5;")
				or die (mysqli_error($conn));
echo "<table> <tr> <th>Company</th> <th>Average Salary</th> </tr>";
while($row = mysqli_fetch_array($exp_query)) {
   echo "<tr> <td>{$row['company']}</td> <td>{$row['Average']}</td> </tr>";
}
echo "</table>";
?>
	
<br>
<br>
<hr size="3" width="90%" color="black">
<br>
<center><h1>Static Questions</h1></center>


<!-- find company with the most bonus compensation -->
<br>
<h2>Which company pays the highest bonus compensation?</h2>
<?php
$bonus_query = mysqli_query($conn, "Select * From Salary where bonus = (Select max(bonus) from Salary);") or die (mysqli_error($conn));
while($row = mysqli_fetch_array($bonus_query)) {
   echo "<p>{$row['company']} pays a {$row['title']} employee $ {$row['bonus']} in bonus compensation</p>";
}
?>




<!-- find company with the most stock grants -->
<br>
<h2>Which company pays the highest in stock grants?</h2>
<?php
$stock_query = mysqli_query($conn, "Select * From Salary where stock_grant_value = (Select max(stock_grant_value) from Salary);") or die (mysqli_error($conn));
while($row = mysqli_fetch_array($stock_query)) {
   echo "<p>{$row['company']} pays a {$row['title']} employee $ {$row['stock_grant_value']} in stock grants</p>";
}
?>



<!-- find the cities with the most entries in dataset -->
<br>
<h2>Which cities have the most entries in the dataset?</h2>
<?php
$count_query = mysqli_query($conn, "SELECT * 
			       	FROM 
				(SELECT city_id, COUNT(*) as Count 
				FROM Salary 
				GROUP BY city_id 
				ORDER BY COUNT(*) 
				DESC LIMIT 3) as X 
				inner join Location as l on l.city_id = X.city_id;") or die (mysqli_error($conn));
echo "<table> <tr> <th>City</th> <th>Count</th> </tr>";
while($row = mysqli_fetch_array($count_query)) {
   echo "<tr> <td>{$row['location']}</td> <td>{$row['Count']}</td> </tr>";
}
echo "</table>";
?>

	
	
<!-- find how much Amazon pays for difference experience levels -->
<br>
<h2>What is the average salary for Amazon employees with different experience levels?</h2>
<?php
$amz_query = mysqli_query($conn, "SELECT years_of_experience, round(avg(total_yearly_compensation)) as avg FROM Salary
				    WHERE company = 'Amazon' GROUP BY company, years_of_experience 
				    ORDER BY years_of_experience;") or die (mysqli_error($conn));
echo "<table> <tr> <th>Yrs of Exp</th> <th>Avg Salary</th> </tr>";
$target = array(0, 3, 5, 10, 15);
while($row = mysqli_fetch_array($amz_query)) {
   if(in_array($row['years_of_experience'], $target)) {
      echo "<tr> <td>{$row['years_of_experience']}</td> <td>{$row['avg']}</td> </tr>";
   }
}
echo "</table>";
?>
	


<!-- find when employees typically get bonuses -->
<br>
<h2>When do employees at a company typically get bonuses?</h2>
<?php
$most_bonus_query = mysqli_query($conn, "SELECT years_at_company, count(bonus) AS number_bonuses FROM Salary
					WHERE bonus > 0 GROUP BY years_at_company ORDER BY number_bonuses
					DESC LIMIT 3;") or die (mysqli_error($conn));
echo "<table> <tr> <th>Yrs at Company</th> <th># Employees with Bonuses</th> </tr>";
while($row = mysqli_fetch_array($most_bonus_query)) {
   echo "<tr> <td>{$row['years_at_company']}</td> <td>{$row['number_bonuses']}</td> </tr>";
}
echo "</table>";
?>
	
	


<!-- find the city with the highest average salary -->
<br>
<h2>Which city has the highest average salary?</h2>
<?php
$city_max_salary_query = mysqli_query($conn, "Select *, round(avg(total_yearly_compensation)) as Average
	From Salary as s
	Inner join Location as l on l.city_id = s.city_id
	Group by location
	Order by Average DESC
	Limit 1;") or die (mysqli_error($conn));
while($row = mysqli_fetch_array($city_max_salary_query)) {
   echo "<p> Employees in {$row['location']} are paid on average $ {$row['Average']} </p>";
}
?>



<!-- find companies that keep their employees the longest -->
<br>
<h2>Which company keeps their employees the longest?</h2>
<?php
$yrs_at_company_query = mysqli_query($conn, "SELECT *, round(AVG(years_at_company),2) as avg_yrs FROM Salary
					     GROUP BY company ORDER BY avg_yrs DESC LIMIT 3;") or die (mysqli_error($conn));
echo "<table> <tr> <th>Company</th> <th>Avg Employee Years At Company</th> </tr>";
while($row = mysqli_fetch_array($yrs_at_company_query)) {
   echo "<tr> <td>{$row['company']}</td> <td>{$row['avg_yrs']}</td> </tr>";
}
echo "</table>";
?>



<!-- find companies that have the most inexperienced employees -->
<br>
<h2>Which company has the most inexperienced employees?</h2>
<?php
$inexperience_query = mysqli_query($conn, "SELECT *, round(AVG(years_of_experience),2) as avg_exp FROM Salary
				       	GROUP BY company ORDER BY avg_exp LIMIT 1;") or die (mysqli_error($conn));
while($row = mysqli_fetch_array($inexperience_query)) {
   echo "<p>Employees at {$row['company']} have on average only {$row['avg_exp']} years of experience </p>";
}
?>





<!-- find companies with highest ratio of managers -->
<br>
<h2>Which companies have the highest percentage of employees that are managers?</h2>
<?php
$manager_ratio_query = mysqli_query($conn, "SELECT emps.company, round(managers/employees*100,2) as percent_managers
	FROM (Select company, count(title) as employees from Salary GROUP BY company)  emps
	LEFT JOIN (Select company, count(title) as managers from Salary
	WHERE title LIKE  '%manager%' GROUP BY company) mgrs
	ON emps.company = mgrs.company ORDER BY percent_managers DESC LIMIT 3;") or die (mysqli_error($conn));
echo "<table> <tr> <th>Company</th> <th>Percent Managers</th> </tr>";
while($row = mysqli_fetch_array($manager_ratio_query)) {
   echo "<tr> <td>{$row['company']}</td> <td>{$row['percent_managers']}</td> </tr>";
}
echo "</table>";
?>



<br>
<br>
<hr size="3" width="90%" color="black">
<br>
<center><h2> Input your own information into the database!</h2></center>
<!-- user input own salary into Salary table -->
<!-- Need company, location, title, total_yearly_compensation, years_of_experience, years_at_company, stock_grant_value, bonus, highest lvl of education -->
<!-- Assign id of # rows + 1, datetime of submited time, city_id of associated location, bachelors masters and doctorate from highest lvl of education -->
<form action="" method="POST">
Company: <input type="text" name="company"><br>
City: 
<?php
$city_query = mysqli_query($conn, "Select distinct location from Location;") or die (mysqli_error($conn));
echo "<select name='city'>";
while ($row = mysqli_fetch_array($city_query)) {
   echo "<option value='" . $row['location'] . "'>" . $row['location'] . "</option>";
}
echo "</select>";
?>

<br>
Title: <input type="text" name="title"><br>
Total Yearly Compensation: <input type="number" name="total_yearly_compensation"><br>
Years of Experience: <input type="number" name="years_of_experience"><br>
Years at Company: <input type="number" name="years_at_company"><br>
Stock Grant: <input type="number" name="stock_grant_value"><br>
Bonus: <input type="number" name="bonus"><br>
Highest Level of Education: <select name="education" id="education">
	<option value="high_school">High School</option>
	<option value="bachelors">Bachelors</option>
	<option value="masters">Masters</option>
	<option value="doctorate">Doctorate</option>
	</select>
<br>
<input type="submit" value="submit"/>
</form>
<!-- php to submit values into database -->
<?php
// id
$prev_query = mysqli_query($conn, "Select count(*) as count from Salary LIMIT 1;") or die (mysqli_error($conn));
$prev_id = mysqli_fetch_array($prev_query);
$new_id = $prev_id['count'] + 1;
// datetime
date_default_timezone_set('America/Chicago');
$datetime = date('Y-m-d H:i:s', time());
// company
$company = filter_var(htmlentities($_POST['company']), FILTER_SANITIZE_STRING);
// city_id
$location = htmlentities($_POST['city']);
$city_query = mysqli_query($conn, "Select city_id from Location where location = \"$location\" LIMIT 1;") or die (mysqli_error($conn));
$city_id = mysqli_fetch_array($city_query);
// title
$title = filter_var(htmlentities($_POST['title']), FILTER_SANITIZE_STRING);
// comp
$total_yearly_compensation = filter_var(htmlentities($_POST['total_yearly_compensation']), FILTER_VALIDATE_INT);
// exp
$years_of_experience = filter_var(htmlentities($_POST['years_of_experience']), FILTER_VALIDATE_INT);
// yrs at company
$years_at_company = filter_var(htmlentities($_POST['years_at_company']), FILTER_VALIDATE_INT);
// stock
$stock_grant_value = filter_var(htmlentities($_POST['stock_grant_value']), FILTER_VALIDATE_INT);
// bonus
$bonus = filter_var(htmlentities($_POST['bonus']), FILTER_VALIDATE_INT);
// education
$degree = htmlentities($_POST['education']);
$bachelors = 0;
$masters = 0;
$doctorate = 0;

if($degree == "bachelors"){$bachelors=1; $masters=0; $doctorate=0;}
elseif($degree == "masters"){$bachelors=1; $masters=1; $doctorate=0;}
else{$bachelors=1; $masters=1; $doctorate=1;}

$update_db = mysqli_query($conn, "INSERT INTO Salary
				  VALUES (\"{$new_id}\", \"{$datetime}\", \"{$company}\", \"{$city_id['city_id']}\", \"{$title}\", \"{$total_yearly_compensation}\", \"{$years_of_experience}\", \"{$years_at_company}\", \"{$stock_grant_value}\", \"{$bonus}\", \"{$masters}\", \"{$bachelors}\", \"{$doctorate}\");") or die (mysqli_error($conn));

echo "<p>Thank you for your submission!</p>";
?>













</table>
</body>
</html>

