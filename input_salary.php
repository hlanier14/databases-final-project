<html>
<body> 


<head>
<style>
	form  {display: table;}
	p     {display: table-row;}
	label {display: table-cell; padding: 10px;}
	input {display: table-cell;}
</head>
</style>




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


<h2> Input your own information into the database!</h2>

<!-- user input own salary into Salary table -->
<!-- Need company, location, title, total_yearly_compensation, years_of_experience, years_at_company, stock_grant_value, bonus, highest lvl of education -->
<!-- Assign id of # rows + 1, datetime of submited time, city_id of associated location, bachelors masters and doctorate from highest lvl of education -->

<form action="thank_you.php" method="POST">
<p><label for="company"> Company: </label> <input type="text" id="company" name="company"><br></p>
<p><label for="city">City: </label>
<?php
$city_query = mysqli_query($conn, "Select distinct location from Location;") or die (mysqli_error($conn));
echo "<select id='city' name='city'>";
// set default select to Select
echo "<option selected='selected' value='select'>Select</option>";
while ($row = mysqli_fetch_array($city_query)) {
   echo "<option value='" . $row['location'] . "'>" . $row['location'] . "</option>";
}
echo "</select>";
?>
</p>
<p><label for="title">Title: </label> <input type="text" id="title" name="title"><br></p>
<p><label for="total_yearly_compensation">Total Yearly Compensation: </label><input type="number" id="total_yearly_compensation" name="total_yearly_compensation"><br></p>
<p><label for="stock_grant_value">Stock Grant: </label><input type="number" id="stock_grant_value" name="stock_grant_value"><br></p>
<p><label for="bonus">Bonus: </label><input type="number" id="bonus" name="bonus"><br></p>
<p><label for="years_of_experience">Years of Experience: </label><input type="number" id="years_of_experience" name="years_of_experience"><br></p>
<p><label for="years_at_company">Years at Company: </label><input type="number" id="years_at_company" name="years_at_company"><br></p>
<p><label for="education"> Highest Level of Education: </label><select name="education" id="education">
	<option selected='selected' value='select'>Select</option>
	<option value="high_school">High School</option>
	<option value="bachelors">Bachelors</option>
	<option value="masters">Masters</option>
	<option value="doctorate">Doctorate</option>
	</select>
</p>
<br>
<input type="submit" value="submit"/>
</form>



</body>
</html>
