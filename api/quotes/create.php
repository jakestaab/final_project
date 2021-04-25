<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow_Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
    Access-Control-Allow_Methods, Authorization, X-Requested-With');


    include_once '../../config/Database.php';
    include_once '../../models/Quotes.php';

    $database = new Database();
    $db = $database->connect();

    $post = new Quotes($db);

    //get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    $post->categoryId = $data->categoryId;
    $post->quote = $data->quote;
    $post->authorId = $data->authorId;

    if($post->create()) {
        echo json_encode(
            array('message' => 'Quote Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Created')
        );
    }