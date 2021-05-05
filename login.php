
<?php
    
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__. "/classes/Database.php");
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header('location: index.php');
        exit;
    }
    

    if (!empty($_POST)){
        try{
            
            
            $user = new User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            if($user->login()) {
                $id = User::getIdByEmail($user->getEmail());
                $user->startSession($id);
                
            }else{
                echo "pech";
            }
            
        } catch (Throwable $th) {
            $error = $th->getMessage();
        }
        
    }




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" placeholder="email">
                <span class="invalid-feedback"><?php echo $error; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="password">
                <span class="invalid-feedback"><?php echo $error; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>