<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow_Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
    Access-Control-Allow_Methods, Authorization, X-Requested-With');


    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $post = new Category($db);

    //get raw authored data
    $data = json_decode(file_get_contents('php://input'));

    $post->category = $data->category;

    if($post->create()) {
        echo json_encode(
            array('message' => 'Category Added')
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Added')
        );
    }