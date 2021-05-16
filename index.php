<?php
include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/TimeAgo.php");
include_once(__DIR__ . "/classes/Comment.php");

include 'header.inc.php';

$post = Post::getAll();
$amount_post = 0;

$timeAgo = new Ago();

//$Comment_posted_at = "2021-05-16 00:01:16";
$timestamp = $timeAgo->convertToTimestamp($Comment_posted_at);


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
        <div class="one_post post" id="post">
            <p href="#" class="username">Username</p>
            <!-- Image post, description, hashtag en timestamp post -->
            <a href="detailpage.php?p=<?php echo $key; ?>">
                <img src="<?php echo 'posts/' . $post['image'] ?>">
            </a>
            <p> <?php echo $post['description']; ?></p>
            <a href="" class="hashtag"><?php echo "#"  ?></a>
            <p class="date"><?php echo $post['date']; ?></p>

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
                    <ul class="list_comments">
                        <?php $allComments = Comment::getPostId($post['id']); ?>
                        <?php foreach ($allComments as $c) : ?>
                            <li>
                                <?php echo htmlspecialchars($c['comment']); ?>
                                <div class="date date_comment"><?php echo $c['date']; ?></div>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <!-- comment inputfield en comment btn -->
                <form method="post" action="">
                    <input type="text" placeholder="Add comment" class="comment_field" id="comment_text">
                    <div class="vl">
                        <button type="submit" id="btn_add_comment" data-post_id="<?php echo $post["id"] ?>">Post</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

    <script src="comment.js"></script>
</body>

</html>