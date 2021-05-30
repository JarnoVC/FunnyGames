<?php

ob_start();
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Database.php");
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    header('location: index.php');
}


if (!empty($_POST)) {

    try {

        /*Nieuwe user aanmaken*/
        $user = new User();

        /*controleren of de invulvelden van email en paswoord
        niet leeg zijn alvoren toegang tot site te geven*/
        if (empty($_POST['email'])) {
            $errorMail = "Please fill in your email";
        } elseif (empty($_POST['password'])) {
            $errorPassword = "Please fill in your password";
        } else {
            if ($user->login($_POST['email'], $_POST['password'])) {
                $id = User::getIDFromEmail($_POST['email']);
                $user->startSession($id);
            } else {
                $errorMail = $errorPassword = "Wrong email or password";
            }
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
    <link rel="icon" href="illustrations/favicon.svg">
    <link rel="stylesheet" media="screen" href="style/login.css">
</head>

<body>
    <div class="wrapper">
        <div class="logo"></div>
        <!--  <h2>Login</h2> -->
        <p>Please fill in your credentials to <strong>login.</strong></p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <!--<label>Email</label> -->
                <input type="text" name="email" class="form-control <?php echo (!empty($errorMail)) ? 'is-invalid' : ''; ?>" placeholder="email">
                <?php if (isset($errorMail)) : ?>
                    <span class="invalid-feedback"><?php echo $errorMail; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <!-- <label>Password</label> -->
                <input type="password" name="password" class="form-control <?php echo (!empty($errorPassword)) ? 'is-invalid' : ''; ?>" placeholder="password">
                <?php if (isset($errorPassword)) : ?>
                    <span class="invalid-feedback"><?php echo $errorPassword; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p class="text_bottom">Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>

</html>