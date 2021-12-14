<html>
<body> 

<h2> Input your own information into the database!</h2>

<!-- user input own salary into Salary table -->
<!-- Need company, location, title, total_yearly_compensation, years_of_experience, years_at_company, stock_grant_value, bonus, highest lvl of education -->
<!-- Assign id of # rows + 1, datetime of submited time, city_id of associated location, bachelors masters and doctorate from highest lvl of education -->

<form action="" method="POST">
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
elseif($degree == "doctorate"){$bachelors=1; $masters=1; $doctorate=1;}

$update_db = mysqli_query($conn, "INSERT INTO Salary
				  VALUES (\"{$new_id}\", \"{$datetime}\", \"{$company}\", \"{$city_id['city_id']}\", \"{$title}\", \"{$total_yearly_compensation}\", \"{$years_of_experience}\", \"{$years_at_company}\", \"{$stock_grant_value}\", \"{$bonus}\", \"{$masters}\", \"{$bachelors}\", \"{$doctorate}\");") or die (mysqli_error($conn));

echo "<p>Thank you for your submission!</p>";
?>

</body>
</html>
