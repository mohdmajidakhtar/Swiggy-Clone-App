<?php
require_once "config.php";

$sql= "DELETE FROM food_items WHERE id='$_GET[id]'";
if(mysqli_query($link,$sql))
{
	header("refresh:1; url=res_homepage.php");
}else{
	echo "Not Deleted!";
}

?>