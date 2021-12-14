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
<br>


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

<form action="salary_info.php">
<input type="submit" value="Return to salary info page"/>
</form>

</html>
</body>
