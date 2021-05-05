<?php
    
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__. "/classes/Database.php");


    
    
    /*if (!empty($_POST)) {
        $username = $email = $password = $confirm_password = "";
        
        
        $email = $_POST['email'];
        $username = $_POST['username'];
        $options = [
            'cost' => 12,
        ];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);


        $user = new User();

        $user->setEmail($email);

    }*/

    

    if (!empty($_POST)){
        try{
            
            
            $user = new User();
            $user->setEmail($_POST['email']);
            $user->setUsername($_POST['username']);
            $user->setPassword($_POST['password']);
            $user->setConfirm_password($_POST['confirm_password']);

            

            try{
                $user->validateEmail();
            } catch (Throwable $th) {
                $error = $th->getMessage();
            }

            $user->register();
            /*if($_POST['password'] === $_POST['confirm_password'] && !empty($_POST['password'])){
                

            } else {
                
            }*/
        } catch (Throwable $th) {
            $error = $th->getMessage();
        }
        
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
                <input type="text" name="email" class="form-control <?php echo (!empty($error)) ? 'is-invalid' : ''; ?>" placeholder="email">
                <?php if (isset($error)) : ?>
                    <span class="invalid-feedback"><?php echo $error; ?></span>
                <?php endif; ?>
            </div>  
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($error)) ? 'is-invalid' : ''; ?>" placeholder="username">
                <?php if (isset($error)) : ?>
                    <span class="invalid-feedback"><?php echo $error; ?></span>
                <?php endif; ?>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($error)) ? 'is-invalid' : ''; ?>" placeholder="password">
                <?php if (isset($error)) : ?>
                    <span class="invalid-feedback"><?php echo $error; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($error)) ? 'is-invalid' : ''; ?>" placeholder="confirm password">
                <?php if (isset($error)) : ?>
                    <span class="invalid-feedback"><?php echo $error; ?></span>
                <?php endif; ?>
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