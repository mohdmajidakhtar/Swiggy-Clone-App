<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


// Include config file
require_once "config.php";

//mysqli_select_db($link,"food_items");
?>

<!DOCTYPE html>
<html>
<head>
 	<title>Cards</title>
<link rel="stylesheet" type="text/css" href="cards.css">
</head>
<body>

	<div class="page_header">	
	     
    <?php
     if(isset($_GET['city']))
    {
    	if($_GET['city']=='all');
        echo "<a id='btn' href='cards.php'>Display city wise</a>";

		
    }
    else{
      echo "<a id='btn' href='cards.php?city=all'>Display All</a>";

    }
    	 
         ?>
         

		<a id="btn" href="reset-password.php">Reset Password</a>
		<a id="btn" href="logout.php">Sign Out</a>
	</div>


<div class="main">
<?php
	//$city_name=mysqli_real_escape_string($link,$city_name);
	
    
    if(isset($_GET['city']))
    {
    	if($_GET['city']=='all');
        $res=mysqli_query($link,"select * from food_items where value='true'");
		
    }
    else{
     	$res=mysqli_query($link,"select * from food_items where city='$city_name' and value='true'");
    }
	
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

			<div class="cart">
				<button>Add to Cart</button>
			</div>
		</div>

		<?php
	}	

?>
