<?php
  // Create database connection
  $db = mysqli_connect("localhost", "root", "", "funnygames");
  $id = "";


  // Initialize the session
	session_start();
	
	// Check if the user is logged in, if not then redirect him to login page
	/*if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
		header("location: login.php");
		exit;
	}*/

  // Initialize message variable
  $msg = "";

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];

  	// image file directory
  	$target = "images/".basename($image);

  	$sql = "UPDATE user SET profile_picture='$image' where id=$id";
  	// execute query
  	mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }

  if (isset($_POST['post'])) {

		// Get text
		$image_text = mysqli_real_escape_string($db, $_POST['image_text']);
  
		$sql = "UPDATE user SET bio='$image_text' where id=$id";
		// execute query
		mysqli_query($db, $sql);
		
}	

if (isset($_POST['delete'])) {
	

		$image_text = mysqli_real_escape_string($db, $_POST['image_text']);
  
		$sql = "UPDATE user SET bio='' where id=$id";

		mysqli_query($db, $sql);
}

if (isset($_POST['change_email'])) {
	

	$email = mysqli_real_escape_string($db, $_POST['email_text']);

	$sql = "UPDATE user SET email='$email' where id=$id";

	mysqli_query($db, $sql);
}

if (isset($_POST['set_username'])) {
	

	$username = mysqli_real_escape_string($db, $_POST['username']);

	$sql = "UPDATE user SET username='$username' where id=$id";

	mysqli_query($db, $sql);
}

  $result = mysqli_query($db, "SELECT * FROM user");
?>
<!DOCTYPE html>
<html>
<head>
<title>Image Upload</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<style type="text/css">
   #content{
   	width: 50%;
   	margin: 20px auto;
   	border: 1px solid #cbcbcb;
   }
   form{
   	width: 50%;
   	margin: 20px auto;
   }
   form div{
   	margin-top: 5px;
   }
   #img_div{
   	width: 80%;
   	padding: 5px;
   	margin: 15px auto;
   	border: 1px solid #cbcbcb;
   }
   #img_div:after{
   	content: "";
   	display: block;
   	clear: both;
   }
   img{
   	float: left;
   	margin: 5px;
   	width: 300px;
   	height: 140px;
   }
   #post_bio, #delete_bio {
	display:inline-block;
	display: flex;
   }
   #email {
	   float: left;
	   margin-right: 25px;
   }
   #upload_button {
	   margin-bottom: 40px;
   }
</style>
</head>
<body>
<div id="content">
  <?php
    $db = mysqli_connect("localhost", "root", "", "funnygames");
    $sql = "SELECT * FROM user";
    $result = mysqli_query($db, $sql);
 
    while ($row = mysqli_fetch_array($result)) {
      echo "<div id='img_div'>";
      	echo "<img src='images/".$row['profile_picture']."' >";
      	echo "<p>".$row['bio']."</p>";
      echo "</div>";
    }


  ?>
  <form method="POST" action="index.php" enctype="multipart/form-data">
  		<input
			type="text"
			name="username" 
			placeholder="gebruikersnaam wijzigen">

			<?php
			$db = mysqli_connect("localhost", "root", "", "funnygames");
			$sql = "SELECT * FROM user";
			$result = mysqli_query($db, $sql);
		
		    while ($row = mysqli_fetch_array($result)) {

				echo "<div id='username'>";
					  echo "<p> huidige gebruikersnaam: <br><b>".$row['username']."</b></p>";
				  echo "</div>";
			  }
		?>
			
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
		<textarea 
			id="text" 
			cols="40" 
			rows="4" 
			name="image_text" 
			placeholder="Say something about this image..."></textarea>
		</div>
		<div>
			<button id="post_bio" type="submit" name="post">POST</button>
		</div>
		<div>
				<button id="delete_bio" type="submit" name="delete">VERWIJDER</button>
		</div>
		<div>
		<input
			type="email"
			name="email_text" 
			placeholder="verander email">
		</div>
		<?php
			$db = mysqli_connect("localhost", "root", "", "funnygames");
			$sql = "SELECT * FROM user";
			$result = mysqli_query($db, $sql);
		
		    while ($row = mysqli_fetch_array($result)) {

				echo "<div id='email'>";
					  echo "<p> huidige email: <br><b>".$row['email']."</b></p>";
				  echo "</div>";
			  }

		?>

		
		<div>
				<button id="delete_bio" type="submit" name="change_email">EMAIL WIJZIGEN</button>
		</div>
  </form>
</div>
</body>
</html>