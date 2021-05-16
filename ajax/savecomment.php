<?php
session_start();
include_once(__DIR__ . "/../classes/Comment.php");
include_once(__DIR__ . "/Database.php");

if (!empty($_POST['comment'])) {

    $c = new Comment();
    $c->setPost_id($_POST['post_id']);
    $c->setComment($_POST['comment']);
    $c->setUser_id($_SESSION['id']);

    $c->savecomment();

    $response = [
        'status' => 'success',
        'body' => htmlspecialchars($c->getComment()),
        'message' => 'comment saved'
    ];

    header('Content-Type: application/json'); //hier komt json terug (vb comment toevoegen in lijst), niet html
    echo json_encode($response); // encoderen naar json
}
