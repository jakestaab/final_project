<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $post = new Category($db);

    //get id
    $post->categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : die();

    //get post
    $post->read_single();

    //create array
    $post_arr = array(
        'id' => $post->id,
        'category_name' => $post->category_name,
    );

    //make JSON
    print_r(json_encode($post_arr));