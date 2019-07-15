<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to main homepage page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: res_homepage.php");
  exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $passw = "";
$email_err = $passw_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter username.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["passw"]))){
        $passw_err = "Please enter your password.";
    } else{
        $passw = trim($_POST["passw"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($passw_err)){
        // Prepare a select statement
        $sql = "SELECT r_id, email, passw, res_name FROM res_users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $r_id, $email, $hashed_password, $res_name);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($passw, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["r_id"] = $r_id;
                            $_SESSION["email"] = $email;   
                            $_SESSION["res_name"] = $res_name;   
                                                    
                            // Redirect user to welcome page
                            header("location: res_homepage.php");
                        } else{
                            // Display an error message if password is not valid
                            $passw_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $email_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <div id="frm">
        <h2>Partner Login Portal</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($passw_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="passw" class="form-control">
                <span class="help-block"><?php echo $passw_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" id="btn" class="btn btn-primary" value="Login">
            </div>
            <p>New restaurant in the town? <a href="res_register.php">Sign Up here</a>.</p>
        </form>
    </div>    
</body>
</html>