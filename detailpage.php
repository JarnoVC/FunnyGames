<?php

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Database.php");
include_once(__DIR__ . "/classes/Post.php");

include 'header.inc.php';


if (!isset($_SESSION["id"])) {
    header("location: login.php");
} else {
    $id = $_SESSION["id"];
    $correct_data = User::UserData($id);
}

$user_id = $_GET['id'];
$correct_data = User::UserData($user_id);
$post = (new Post)->getCorrectPost($user_id);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/detailpage.css">
    <title>Profile</title>
</head>

<body>
    <p class="username"><?php echo $correct_data['username']; ?><span class="s_profile">'s profile</span></p>

    <?php foreach (array_reverse($post) as $post) : ?>
        <div class="contain_img">
            <img class="posts" src="posts/<?php echo $post['image']; ?>">
        </div>
    <?php endforeach; ?>

</body>

</html>