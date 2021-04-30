<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow_Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
    Access-Control-Allow_Methods, Authorization, X-Requested-With');


    require('../../config/Database.php');
    require('../../models/Author.php');

    $database = new Database();
    $db = $database->connect();

    $post = new Author($db);

    //get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    //set id to update
    $post->id = $data->id;

    //update post
    if($post->delete()) {
        echo json_encode(
            array('message' => 'Author Deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Author Not Deleted')
        );
    }