<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow_Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
    Access-Control-Allow_Methods, Authorization, X-Requested-With');


    require('../../config/Database.php');
    require('../../models/Quotes.php');

    $database = new Database();
    $db = $database->connect();

    $post = new Quotes($db);

    //get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    //set id to update
    $post->id = $data->id;

    $post->categoryId = $data->categoryId;
    $post->quote = $data->quote;
    $post->authorId = $data->authorId;

    //update post
    if($post->update()) {
        echo json_encode(
            array('message' => 'Post Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Post Not Updated')
        );
    }