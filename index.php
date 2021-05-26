<?php
include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/TimeAgo.php");
include_once(__DIR__ . "/classes/Comment.php");

include 'header.inc.php';

/*session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: login.php');
    exit();
}*/

$post = Post::getAll();
$amount_post = 0;

$dateAgo = new Ago();

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
    <?php foreach (array_reverse($post) as $key => $post) : ?>
        <?php
        $amount_post++;
        if ($amount_post > 20) { // als meer dan 20 posts op feed,
            break; //break

        }
        ?>
        <div id="commentquery">
            <div class="one_post post" id="post">
                <p href="#" class="username">Username</p>
                <!-- Image post, description, hashtag en timestamp post -->
                <a href="detailpage.php?p=<?php echo $key; ?>">
                    <img src="<?php echo 'posts/' . $post['image'] ?>">
                </a>
                <p> <?php echo $post['description']; ?></p>
                <a href="" class="hashtag"><?php echo "#" . $post['hashtag'] ?></a>
                <?php date_default_timezone_set('Europe/Brussels'); ?>
                <?php $curenttime = ($post['date']); ?>
                <!-- timestamp post is geplaatst in databank -->
                <?php $time_ago = strtotime($curenttime); ?>
                <!-- timestamp omgezet naar ... ago (met function timeAgo) -->
                <p class="date"><?php echo $dateAgo->timeAgo($time_ago); ?></p> <!-- echo ... ago -->

                <!-- comments en likes post -->
                <div class="post_right_side">
                    <div class="hl"></div>
                    <!-- likes -->
                    <div class="likes">
                        <a href="#" class="like_btn">like</a>
                        <span id="likes_counter">0</span> people liked this post.
                    </div>

                    <!-- comment foreach -->

                    <div class="area_comments">
                        <div class="empty"></div>
                        <ul class="list_comments">
                            <?php $allComments = Comment::getPostId($post['id']); ?>
                            <?php foreach ($allComments as $c) : ?>
                                <li>
                                    <?php echo htmlspecialchars($c['comment']); ?>
                                    <?php $curenttime = ($c['date']); ?>
                                    <?php $time_ago = strtotime($curenttime); ?>
                                    <div class="date date_comment"><?php echo $dateAgo->timeAgo($time_ago); ?></div>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <!-- comment inputfield en comment btn -->
                    <input type="text" placeholder="Add comment" class="comment_field" id="comment_text">

                    <div class="vl">
                        <button type="submit" id="btn_add_comment" data-post_id="<?php echo $post["id"] ?>">Post</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script src="comment.js"></script>
</body>

</html>
