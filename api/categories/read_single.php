<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require('../../config/Database.php');
    require('../../models/Category.php');

    $database = new Database();
    $db = $database->connect();

    $post = new Category($db);

    //get id
    $post->id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    //get post
    $post->read_single($post->id);

    //create array
    $post_arr = array(
        'id' => $post->id,
        'category_name' => $post->category_name,
    );

    //make JSON
    print_r(json_encode($post_arr));