<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: res_login.php");
    exit;
}

$res = $_SESSION["res_name"];

// Include config file
require_once "config.php";
?>


<!DOCTYPE html>
<html>
<head>
 	<title>Profile</title>
<link rel="stylesheet" type="text/css" href="cards.css">
</head>
<body>
	<div class="page_header">	
		<a id="btn" href="addnew.php">Add New</a>
		<a id="btn" href="res_logout.php">Sign Out</a>\
	</div>

<?php
//Execute the query
$records = mysqli_query( $link,"SELECT * FROM food_items where res='$res'"); 
?>

<br>
<br>
<h2>Your Food Items</h2>
<table>
	<tr>
		<th>Item Name</th>
		<th>City</th>
		<th>Price</th>
		<th>Delete</th>
		<th>Update</th>
	</tr>
	<?php
	while ($row = mysqli_fetch_array($records)) {
		echo "<tr><form action=update.php method=post>";
		echo "<td><input type=text name=name value='".$row['name']."'></td>";
		echo "<td><input type=text name=city value='".$row['city']."'></td>";
		echo "<td><input type=text name=price value='".$row['price']."'></td>";
		echo "<input type=hidden name=id value='".$row['id']."'>";
		echo "<td><a href=delete.php?id=".$row['id'].">Delete</a></td>";
		echo "<td><input type=submit value='Update Info'>";
		echo "</form></tr>";	
	}
	?>
</table>

</body>
</html>