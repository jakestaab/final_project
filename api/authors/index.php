<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require('../../config/Database.php');
    require('../../models/Author.php');

    $database = new Database();
    $db = $database->connect();

    $author = new Author($db);

    $result = $author->read();
    $num = $result->rowCount();

    if($num > 0) {
        $auth_arr = array();
        $auth_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $auth_item = array(
                'id' => $id,
                'author' => $author
            );

            // push to "data"
            array_push($auth_arr['data'], $auth_item);
        }

        // Turn to JSON & output
        echo json_encode($auth_arr);
    } else {
        // No authors
        echo json_encode(
            array('message' => 'No Authors Found')
        );
    }