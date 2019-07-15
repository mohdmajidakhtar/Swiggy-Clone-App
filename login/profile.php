<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";




<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
</head>
<body>
	<div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
        <label>New Password</label>
	    <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
   		<span class="help-block"><?php echo $new_password_err; ?></span>
    </div>
</body>
</html>