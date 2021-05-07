<?php

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Database.php");

if (!empty($_POST)) {
    try {

        /*Aanmaken nieuwe user*/
        $user = new User();
        /*Nieuwe email zetten en foutmelding opvangen*/
        try {
            $user->setEmail($_POST['email']);
        } catch (Throwable $th) {
            $errorMail = $th->getMessage();
        }
        /*Nieuwe username zetten en foutmelding opvangen*/
        try {
            $user->setUsername($_POST['username']);
        } catch (Throwable $th) {
            $errorUsername = $th->getMessage();
        }
        /*Nieuw paswoord zetten en foutmelding opvangen*/
        try {
            $user->setPassword($_POST['password']);
        } catch (Throwable $th) {
            $errorPassword = $th->getMessage();
        }
        /*Paswoord bevestiging en foutmelding opvangen*/
        try {
            $user->setConfirm_password($_POST['confirm_password']);
        } catch (Throwable $th) {
            $errorConfirm = $th->getMessage();
        }
        /*Controleren of paswoord en de confirm paswoord hetzelfde zijn*/
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $errorConfirm = "Confirm password must be the same as password";
        }
        /*controleren of de gekozen email en username niet al bestaan in de database*/
        if ($user->validateEmail($_POST['email'])) {
            $errorMail = "Email already in use";
        } else {
            if ($user->validateUsername($_POST['username'])) {
                $errorUsername = "Username already in use";
            } else {
                $user->register();
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
    <title>Sign Up</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/register.css">
</head>

<body>
    <div class="wrapper">
        <div class="logo"></div>
        <!--   <h2>Sign Up</h2> -->
        <p>Please fill this form to <strong> create an account.</strong></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group">
                <!-- <label>Email</label> -->
                <input type="text" name="email" class="form-control <?php echo (!empty($errorMail)) ? 'is-invalid' : ''; ?>" placeholder="email">
                <?php if (isset($errorMail)) : ?>
                    <span class="invalid-feedback"><?php echo $errorMail; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <!-- <label>Username</label> -->
                <input type="text" name="username" class="form-control <?php echo (!empty($errorUsername)) ? 'is-invalid' : ''; ?>" placeholder="username">
                <?php if (isset($errorUsername)) : ?>
                    <span class="invalid-feedback"><?php echo $errorUsername; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <!--  <label>Password</label> -->
                <input type="password" name="password" class="form-control <?php echo (!empty($errorPassword)) ? 'is-invalid' : ''; ?>" placeholder="password">
                <?php if (isset($errorPassword)) : ?>
                    <span class="invalid-feedback"><?php echo $errorPassword; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <!--  <label>Confirm Password</label> -->
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($errorConfirm)) ? 'is-invalid' : ''; ?>" placeholder="confirm password">
                <?php if (isset($errorConfirm)) : ?>
                    <span class="invalid-feedback"><?php echo $errorConfirm; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="reset" class="btn btn-secondary" value="Reset">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p class="text_bottom">Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>

</html>