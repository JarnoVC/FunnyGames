<?php

	include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__. "classes/Database.php");
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }

	echo "welcome";

?>