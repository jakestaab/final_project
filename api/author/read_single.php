<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $post = new Author($db);

    //get id
    $post->authorId = isset($_GET['authorId']) ? $_GET['authorId'] : die();

    //get post
    $post->read_single();

    //create array
    $post_arr = array(
        'id' => $post->id,
        'author_name' => $post->author_name
    );

    //make JSON
    print_r(json_encode($post_arr));