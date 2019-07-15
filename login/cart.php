<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
      
$city_name=$_SESSION["city_name"];
$rid=$_SESSION["id"];

// Include config file
require_once "config.php";

//mysqli_select_db($link,"food_items");
?>

    <?php
    

     if(isset($_POST['addtocart']))
    {
    	     
    
       if(isset($_POST['itemid']))
       {$itemid=$_POST['itemid'];}
 
       if(isset($_POST['qty']))
       {$qty=$_POST['qty'];}
 
       if(isset($_POST['itemname']))
       {$itemname=$_POST['itemname'];}
 
       if(isset($_POST['price']))
       {$price=$_POST['price'];}

       $amount = $qty*$price;

    // Prepare an insert statement
        $sql = "INSERT INTO cart ( rid, itemid, itemname,price ,qty, amount) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
           
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iisiii",$rid, $itemid, $itemname,$price ,$qty, $amount);
        



            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                //header("location: cart.php");
                echo "added successfull";
            } else{
                echo  mysqli_error($link);
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
       
    }

?>


<!DOCTYPE html>
<html>
<head>
 	<title>Cards</title>
<link rel="stylesheet" type="text/css" href="cards.css">
</head>
<body>

	<div class="page_header">	
	     
        <a id="btn" href="cards.php">Continue Shopping</a>
		
  		<a id="btn" href="reset-password.php">Reset Password</a>
		<a id="btn" href="logout.php">Sign Out</a>
	</div>


<div class="main">
	
   	<div class="card">

			
			<table border=1>
			<tr >
			    <th>Serial No</th>
			    <th>Name</th>
			    <th>Amount</th>
            </tr>

<?php
             $sno=0;
             $total=0;

                    $res=mysqli_query($link,"select * from cart where rid='$rid'");
                     while ($row=mysqli_fetch_array($res)) 
	                {
	 ?>   
	     <tr>
	     <td><?php echo ++$sno;?></td>

	     <td><?php echo $row['itemname'];?></td>
         <td> <?php echo $row['amount'];?></td>
         <?php $total+=$row['amount'];?>
        </tr>
      <?php

      }

     ?>

     </table>

   <?php echo "TOTAL= ". $total; ?>      



		</div>

</div>
</body>
</html>