<?php
require_once "config.php";

$sql= "UPDATE food_items SET name='$_POST[name]', city='$_POST[city]', price='$_POST[price]' WHERE id='$_POST[id]'";
if(mysqli_query($link,$sql))
{
	header("refresh:1; url=res_homepage.php");
}else{
	echo "Not Update!";
}

?>