<?php
include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/User.php");
session_start();

include 'header.inc.php';

$post = Post::getAll();



$amount_post = 0;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunnyGames</title>
    <link rel="icon" href="illustrations/favicon.svg">
    <link rel="stylesheet" href="style/index.css">
</head>

<body>

    <?php foreach (array_reverse($post) as $post) : ?>

        <?php
        $amount_post++;
        if ($amount_post > 20) {
            break;
        }
        ?>
        <div class='one_post'>
            <img src="<?php echo 'posts/' . $post['image'] ?>">
            <p> <?php echo $post['description']; ?></p>

            <a href="" class="hashtag"><?php echo "#"  ?></a>

            <p class="date"><?php echo $post['date']; ?></p>
            <form action="">
                <input type="text" placeholder="Add comment" class="comment_field">
            </form>
        </div>
    <?php endforeach; ?>


</body>

</html>