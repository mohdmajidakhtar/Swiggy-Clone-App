<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $passw = $confirm_passw = $res_name =  $phone_num =  $document =  $city_town = $zip = "";
$email_err = $passw_err = $confirm_passw_err = $res_name_err =  $phone_num_err =  $document_err =  $city_town_err =  $zip_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT r_id FROM res_users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This username is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["passw"]))){
        $passw_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["passw"])) < 6){
        $passw_err = "Password must have atleast 6 characters.";
    } else{
        $passw = trim($_POST["passw"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_passw"]))){
        $confirm_passw_err = "Please confirm password.";     
    } else{
        $confirm_passw = trim($_POST["confirm_passw"]);
        if(empty($passw_err) && ($passw != $confirm_passw)){
            $confirm_passw_err = "Password did not match.";
        }
    }

    // Validate Restaurant's Name
    if(empty(trim($_POST["res_name"]))){
        $res_name_err = "Please enter Restaurant Name.";     
    } else{
        $res_name = trim($_POST["res_name"]);
    }

    // Validate Zip Name
    if(empty(trim($_POST["zip"]))){
        $zip_err = "Please enter a Zip Code.";     
    } else{
        $zip = trim($_POST["zip"]);
    }

    // Validate City Name
    if(empty(trim($_POST["city_town"]))){
        $city_town_err = "Please enter a City Name.";     
    } else{
        $city_town = trim($_POST["city_town"]);
    }
            
    // Validate Phone Number
    if(empty(trim($_POST["phone_num"]))){
        $phone_num_err = "Please enter a Phone Number.";     
    } else{
        $phone_num = trim($_POST["phone_num"]);
    }
    

    //photo valudation
    if(isset($_FILES['document']))
    {
        $tmp_name=$_FILES['document']['tmp_name'];
        $file_name=$_FILES['document']['name'];
        move_uploaded_file($tmp_name, "docs/".$file_name);
        $document="docs/".date("Ymd").$file_name;


    }

    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($passw_err) && empty($confirm_passw_err) && empty($city_town_err) && empty($res_name_err) && empty($phone_num_err) && empty($document_err) && empty($zip_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO res_users (res_name, zip, city_town, phone_num, email, passw, document) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            // Set parameters
            $param_res_name = $res_name;
            $param_zip = $zip;
            $param_city_town = $city_town;
            $param_phone_num = $phone_num;
            $param_email = $email;
            $param_passw = password_hash($passw, PASSWORD_DEFAULT); // Creates a password hash
            $param_document = $document;
            

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisssss", $param_res_name, $param_zip, $param_city_town, $param_phone_num, $param_email, $param_passw, $param_document);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page

                header("location: res_login.php");
            } else{
                
                echo mysqli_error($link);
                echo "Something went wrong. Please try again later.";
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
    <title>Restaurant Partners</title>
    <link rel="stylesheet" href="style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div id="frm">
        <h2>Partner With Us</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($passw_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="passw" class="form-control" value="<?php echo $passw; ?>">
                <span class="help-block"><?php echo $passw_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_passw_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_passw" class="form-control" value="<?php echo $confirm_passw; ?>">
                <span class="help-block"><?php echo $confirm_passw_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($res_name_err)) ? 'has-error' : ''; ?>">
                <label>Restaurant Name</label>
                <input type="text" name="res_name">
            </div>

            <div class="form-group <?php echo (!empty($zip_err)) ? 'has-error' : ''; ?>">
                <label>Zip</label>
                <input type="text" name="zip">
            </div>

            <div class="form-group <?php echo (!empty($city_town_err)) ? 'has-error' : ''; ?>">
                <label>City/Town</label>
                <input type="text" name="city_town">
            </div>

            <div class="form-group <?php echo (!empty($phone_num_err)) ? 'has-error' : ''; ?>">
                <label>Phone Number</label>
                <input type="text" name="phone_num">
            </div>

            <div class="form-group <?php echo (!empty($document_err)) ? 'has-error' : ''; ?>">
                <label>Upload Document</label>
                <input type="file" name="document">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="res_login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>