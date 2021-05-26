<?php
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__. "/classes/Database.php");
    /*if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }*/

    // Initialize the session
    session_start();
    if (!isset($_SESSION['id'])) {
        header('location: login.php');
    } else {
        $sessionId = $_SESSION['id'];
        $userData = User::UserData($sessionId);
        //echo "dag " . $userData['firstname'] . " met id: " . $_SESSION['id'];
    }

    $user = new User();
    $username = $userData['username'];
    
    $email = $userData['email'];
    if ($user->checkBio($email) === true) {
        $bio = $userData['bio'];
    } else {
        $bio = "Post a bio here";
    }
    if (isset($_POST['upload'])) {
        $image = $_FILES['image']['name'];
        $target = "images/".basename($image);
        $user->changeProfilePicture($image, $userData['email']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
        }
    }

    if (isset($_POST['set_username'])) {
        $username = $_POST['username'];
        if ($user->validateUsername($username)) {
            $errorusername = "Username is already taken";
            $username = $userData['username'];
        } else  {
            $user->changeUsername($username, $userData['email']);
        }
        
    }

    if (isset($_POST['post'])) {
        $user->setBio($_POST['image_text']);
        //echo $user->getBio();
        $user->updateBio($user->getBio(), $userData['email']);
        $bio = $userData['bio'];
    }

    if (isset($_POST['change_email'])) {
        $newEmail = $_POST['email_text'];
        $email = $_POST['email_text'];
        if ($user->validateEmail($newEmail)) {
            $errorEmail = "Email is already taken";
            $newEmail = $userData['email'];
        } else  {
            $user->changeEmail($newEmail, $userData['email']);
            $email = $userData['email'];
        }
        
        //$email = $userData['email'];
    }   
    //$email = $userData['email']; 
?>
<!DOCTYPE html>
<html>

<head>
    <title>Image Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" media="screen" href="style/profile.css">
    <link rel="icon" href="illustrations/favicon.svg">
</head>

<body>
    <?php include 'header.inc.php'; ?>
    <div id="content">
        <?php 
            if (isset($image)) {
                echo "<div id='img_div'>";
                echo "<img src='images/".$userData['profile_picture']."' >";
                echo "</div>"; 
            }
            
        ?>

        <form method="POST" action="index.php" enctype="multipart/form-data">
            <input type="text" name="username" placeholder="gebruikersnaam wijzigen">

            <?php 
                echo "<div id='username'>";
                echo "<p> huidige gebruikersnaam: <br><b>".$username."</b></p>";
                echo "</div>";
                if (isset($errorusername)) {
                    echo "<span class='invalid-feedback'><?php echo $errorusername; ?></span>";
                }
            ?>
            <?php if (isset($errorusername)) : ?>
                <span class="invalid-feedback"><?php echo $errorusername; ?></span>
            <?php endif; ?>

            <div>
                <button id="username_button" type="submit" name="set_username">OPSLAAN</button>
            </div>
            <input type="hidden" name="size" value="1000000">
            <div>
                <input type="file" name="image">
            </div>
            <div>
                <button id="upload_button" type="submit" name="upload">UPLOAD</button>
            </div>

            <div>
                <textarea id="text" cols="40" rows="4" name="image_text" placeholder='<?php echo $bio ?>'></textarea>
            </div>
            <div>
                <button id="post_bio" type="submit" name="post">POST</button>
            </div>
            <div>
                <button id="delete_bio" type="submit" name="delete">VERWIJDER</button>
            </div>
            <div>
                <input type="email" name="email_text" placeholder="verander email">
            </div>
            <?php 
            echo "<div id='username'>";
            echo "<p> huidige email: <br><b>".$email."</b></p>";
            echo "</div>";
                 
        ?>


            <div>
                <button id="delete_bio" type="submit" name="change_email">EMAIL WIJZIGEN</button>
            </div>
        </form>
        <div>
            <button><a href="logout.php">logout</a></button>
        </div>
    </div>
</body>

</html>
