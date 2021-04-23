<?php
// Include config file
require_once "database.php";
 
// Define variables en initialize met lege waarden
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

$options = [
    'cost' => 12,
];
 
// Processing form data wanneer de form gesubmit is
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Username valideren
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM person WHERE username = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            //  Variabelen binden aan de SQL statement als parameteres
            $stmt->bind_param("s", $param_username);
            
            // parameters zetten
            $param_username = mysqli_real_escape_string(trim($_POST["username"]));
            
            // Statement uitvoeren
            if ($stmt->execute()) {
                // resultaat opslagen
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Email valideren
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM person WHERE email = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            //  Variabelen binden aan de SQL statement als parameteres
            $stmt->bind_param("s", $param_email);
            
            // parameters zetten
            $param_email = mysqli_real_escape_string(trim($_POST["email"]));
            
            // Statement uitvoeren
            if ($stmt->execute()) {
                // resultaat opslagen
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    
    // password valideren
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // bevestig password valideren
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // input controleren op errors voor deze in de database gestoken worden
    if (empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // insert statement klaarzetten
        $sql = "INSERT INTO person (email, username, password) VALUES (?, ?, ?)";
         
        if ($stmt = $mysqli->prepare($sql)) {
            // Variabelen binden aan de SQL statement als parameteres
            $stmt->bind_param("sss", $param_email, $param_username, $param_password);
            
            // parameters zetten
            $param_email = mysqli_real_escape_string($email);
            $param_username = mysqli_real_escape_string($username);
            $param_password = mysqli_real_escape_string(password_hash($password, PASSWORD_BCRYPT, $options)); // password hashen
            
            // SQL statement uitvoeren
            if ($stmt->execute()) {
                // Redirect naar login page
                header("location: login.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            
            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>  
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>