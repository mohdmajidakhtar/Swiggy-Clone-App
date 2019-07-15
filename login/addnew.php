<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$img =  $name =  $category = $rating = $time = $city = $price = $res_name ="";
$img_err =  $name_err =  $category_err = $rating_err = $time_err = $city_err = $price_err = $res_name_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate Restaurant's Name
    if(empty(trim($_POST["res"]))){
        $res_err = "Please enter Restaurant Name.";     
    } else{
        $res = trim($_POST["res"]);
    }

    // Validate Item Name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter Item Name.";     
    } else{
        $name = trim($_POST["name"]);
    }

    // Validate Category
    if(empty(trim($_POST["category"]))){
        $category_err = "Please enter Category.";     
    } else{
        $category = trim($_POST["category"]);
    }
    
    // Validate Rating
    if(empty(trim($_POST["rating"]))){
        $rating_err = "Please enter rating.";     
    } else{
        $rating = trim($_POST["rating"]);
    }
    
    // Validate Time
    if(empty(trim($_POST["time"]))){
        $time_err = "Please enter time.";     
    } else{
        $time = trim($_POST["time"]);
    }

    // Validate City Name
    if(empty(trim($_POST["city"]))){
        $city_err = "Please enter a City Name.";     
    } else{
        $city = trim($_POST["city"]);
    }
                
    // Validate Price
    if(empty(trim($_POST["price"]))){
        $price_err = "Please enter a Price.";     
    } else{
        $price = trim($_POST["price"]);
    }

     //photo validation
    if(isset($_FILES['img']))
    {
        $tmp_name=$_FILES['img']['tmp_name'];
        $file_name=$_FILES['img']['name'];
        move_uploaded_file($tmp_name, "foodimg/".date("Ymd").$file_name);
        $img="foodimg/".date("Ymd").$file_name;
    }

   
    // Check input errors before inserting in database
    if(empty($name_err) && empty($category_err) && empty($rating_err) && empty($city_err) && empty($res_err) && empty($time_err) && empty($img_err) && empty($price_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO food_items ( img, name, category, rating,`time`, city, price, res) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            // Set parameters
            $param_img = $img;
            $param_name = $name;
            $param_category = $category;
            $param_rating = $rating;
            $param_time = $time;
            $param_city = $city;
            $param_price=$price;
            $param_res=$res;

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssdisis", $param_img, $param_name, $param_category, $param_rating, $param_time, $param_city, $param_price, $param_res);
        



            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: res_homepage.php");
            } else{
                echo  mysqli_error($link);
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
        <h3>Add New Item</h2>
        <p>Please fill this form to add new Entry.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group <?php echo (!empty($res_err)) ? 'has-error' : ''; ?>">
                <label>Restaurant Name</label>
                <input type="text" name="res">
            </div>

            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Item Name</label>
                <input type="text" name="name">
            </div>

            <div class="form-group <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
                <label>Category</label>
                <input type="text" name="category">
            </div>

            <div class="form-group <?php echo (!empty($rating_err)) ? 'has-error' : ''; ?>">
                <label>Rating</label>
                <input type="text" name="rating">
            </div>

            <div class="form-group <?php echo (!empty($time_err)) ? 'has-error' : ''; ?>">
                <label>Time</label>
                <input type="text" name="time">
            </div>

            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                <label>City</label>
                <input type="text" name="city">
            </div>

            <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                <label>Cost for Two</label>
                <input type="text" name="price">
            </div>

            <div class="form-group <?php echo (!empty($img_err)) ? 'has-error' : ''; ?>">
                <label>Upload Image</label>
                <input type="file" name="img">
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