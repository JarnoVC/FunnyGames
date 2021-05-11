<?php 

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Database.php");

$user = new User();
$data = $user->getUsers();
//var_dump($data);

$key = $_GET['p'];
//echo $key;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>joe</title>
</head>
<body>
    <img src='images/<?php echo $data[$key]['profile_picture']; ?>'> 
    <?php echo $data[$key]['username']; ?>

    <?php echo $data[$key]['bio']; ?>
    <?php echo $data[$key]['email']; ?>


</body>
</html>
