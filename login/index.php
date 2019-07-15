<?php
// Include config file
require_once "config.php";
?>

<!DOCTYPE html>
<html>
<head>
 	<title>Cards</title>
<link rel="stylesheet" type="text/css" href="cards.css">
</head>
<body>

	<div class="page_header">	
		<a id="btn" href="register.php">Create Account</a>
		<a id="btn" href="login.php">LOGIN</a>
		<a id="btn" href="res_register.php">Partner With Us</a>
	</div>


<div class="main">
<?php
	//$city_name=mysqli_real_escape_string($link,$city_name);
	
	$res=mysqli_query($link,"select * from food_items");
	while ($row=mysqli_fetch_array($res)) 
	{
	?>
		<div class="card">

			<div class="image">
		   		<img src="<?php echo $row["img"]; ?>">
			</div>
			
			<div class="title">
		 		<h1><?php echo $row["name"]; ?></h1>
			</div>

			<div class="des">
		 		<p><?php echo $row["category"]; ?></p>
			</div>

			<div class="ratings">
				<p><font size="2">&#9733 <?php echo $row["rating"]; ?></p>
			</div>
			<div class="time">
				<p><font size="2"><?php echo $row["time"]; ?> mins</p>
			</div>
			<div class="price">
				<p><font size="2">&#8377 <?php echo $row["price"]; ?> for two</p>
			</div>

			<br>
		</div>

		<?php
	}	

?>

</div>
</body>
</html>