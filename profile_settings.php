<?php
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Database.php");

// Initialize the session
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login.php');
} else {
    $session_id = $_SESSION['id'];
    $userData = User::UserData($session_id);
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
    $target = "images/" . basename($image);
    $user->changeProfilePicture($image, $userData['email']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "Failed to upload image";
    }
}

if (isset($_POST['set_username'])) {
    $username = $_POST['username'];
    if ($user->validateUsername($username)) {
        $errorusername = "Username is already taken";
        $username = $userData['username'];
    } else {
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
    } else {
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
    <title>My profile</title>
    <link rel="stylesheet" media="screen" href="style/profile_settings.css">
    <link rel="icon" href="illustrations/favicon.svg">
</head>

<body>
    <?php include 'header.inc.php'; ?>
    <div id="content">
        <form method="POST" action="index.php" enctype="multipart/form-data">
            <div class="img_username">
                <div id='img_div'>
                    <img src="images/<?php echo $userData['email']; ?>">
                </div>
                <div>
                    <input type="file" name="image" class="input_img">
                </div>
                <div id='username'>
                    <p class="welcome_text">Current username:<span class="username"> <?php echo $username ?></span></p>
                </div>

                <?php
                if (isset($errorusername)) {
                    echo "<span class='invalid-feedback'><?php echo $errorusername; ?></span>";
                }
                ?>
                <?php if (isset($errorusername)) : ?>
                    <span class="invalid-feedback"><?php echo $errorusername; ?></span>
                <?php endif; ?>
                <input type="text" name="username" class="username_input input" placeholder="Change username">
                <div>
                    <button id="username_button" type="submit" class="btn" name="set_username">Save username</button>
                </div>
                <input type="hidden" name="size" value="1000000">
                <div>
                    <button id="upload_button" type="submit" class="btn" name="upload">Save profile picture</button>
                </div>
            </div>
            <div>
                <textarea id="text" cols="40" rows="4" name="image_text" placeholder='<?php echo $bio ?>'></textarea>
            </div>
            <div>
                <button id="post_bio" type="submit" class="btn" name="post">Save bio</button>
            </div>
            <div>
                <button id="delete_bio" type="submit" class="btn_delete" name="delete">Delete bio</button>
            </div>

            <div id='username'>
                <p>current email: <strong><span class="email"> <?php echo $email ?></span></strong></p>
            </div>

            <div>
                <input type="email" name="email_text" class="email_input input" placeholder="Change email">
            </div>



            <div>
                <button id="delete_bio" type="submit" class="btn" name="change_email">Save new email</button>
            </div>
        </form>
        <div>
            <button class="btn logout_btn"><a href="logout.php">logout</a></button>
        </div>
    </div>
</body>

</html>