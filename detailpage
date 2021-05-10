<?php 

include_once('database.php');
include_once('user.php');

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
<div class="profielfoto">
    <img src='images/<?php echo $data[$key]['profile_picture']; ?>'> 
    <?php echo $data[$key]['username']; ?>
</div>
    <?php echo $data[$key]['bio']; ?>
    <?php echo $data[$key]['email']; ?>


</body>
</html>
