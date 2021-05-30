<?php
include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/TimeAgo.php");
include_once(__DIR__ . "/classes/Comment.php");
include_once(__DIR__ . "/classes/Database.php");

include 'header.inc.php';


if (!isset($_SESSION["id"])) {
    header("Location: login.php");
} else {
    $email = $_SESSION["id"];
    $correct_data = User::getIDFromEmail($email);
}


$post = Post::getAll();
$amount_post = 0;

$dateAgo = new Ago();

$user = new User();
$data = $user->getUsers();

$newPost = new Post;

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
    <?php foreach (array_reverse($post) as  $post) : ?>
        <?php
        $amount_post++;
        if ($amount_post > 20) { // als meer dan 20 posts op feed,
            break; //break

        }
        ?>
        <div id="commentquery">
            <div class="one_post post" id="post">
                <a href="detailpage.php?id=<?php echo $post['user_id']; ?>" class="username_link">
                    <p class="username"> <?php echo $newPost->getCorrectUser($post['id'])['username']; ?></p>
                </a>
                <!-- Image post, description, hashtag en timestamp post -->

                <img src="<?php echo 'posts/' . $post['image'] ?>">

                <p> <?php echo $post['description']; ?></p>

                <a href="" class="hashtag"><?php echo "#" ?></a>
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
                                    <a class="username_link username_comment"> <?php echo htmlspecialchars($c['username']); ?></a>
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