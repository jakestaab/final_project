<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require('../../config/Database.php');
    require('../../models/Quotes.php');

    $database = new Database();
    $db = $database->connect();

    $post = new Quotes($db);
    

    if(isset($_GET['authorId']) && !isset($_GET['categoryId'])) {
        $post->authorId = $_GET['authorId'];
        $result = $post->read_single_author($post->authorId);
    } else if (!isset($_GET['authorId']) && isset($_GET['categoryId'])) {
        $post->categoryId = $_GET['categoryId'];
        $result = $post->read_single_category($post->categoryId);
    } else if (isset($_GET['authorId']) && isset($_GET['categoryId'])) {
        $post->authorId = $_GET['authorId'];
        $post->categoryId = $_GET['categoryId'];
        $result = $post->read_category_and_author($post->categoryId, $post->authorId);
    }  else if (isset($_GET['limit'])) {
        $post->limit = $_GET['limit'];
        $result = $post->limit_amount($post->limit);
    } else {
        $result = $post->read();
    }


    $num = $result->rowCount();

    
    if($num > 0) {
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = array(
                'id' => $id,
                'quote' => $quote,
                'category_name' => $category_name,
                'author_name' => $author_name,
            );

            // push to "data"
            array_push($posts_arr['data'], $post_item);
        }

        // Turn to JSON & output
        echo json_encode($posts_arr);
    } else {
        // No posts
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
