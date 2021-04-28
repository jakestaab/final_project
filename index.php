<?php
header('Access-Control-Allow-Origin: *');
require('./config/database.php');
require('./models/Author.php');
require('./models/Category.php');
require('./models/Quotes.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_quotes';
    }
}

$database = new Database();
$db = $database->connect();

$post = new Quotes($db);
$authors = new Author($db);
$categories = new Category($db);

if($action == 'list_quotes') {
    $authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
    $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);

    $auth_result = $authors->get_authors();
    $cat_result = $categories->get_categories();

    if(isset($_GET['authorId']) && $authorId != 0 && $categoryId == 0) {
        $post->authorId = $_GET['authorId'];
        $result = $post->read_single_author($authorId);
    } else if ($authorId == 0 && isset($_GET['categoryId']) && $categoryId != 0) {
        $post->categoryId = $_GET['categoryId'];
        $result = $post->read_single_category($categoryId);
    } else if ($categoryId == 0 && $authorId == 0) {
        $result = $post->read();
    } else if (isset($_GET['authorId']) && isset($_GET['categoryId'])) {
        $post->authorId = $_GET['authorId'];
        $post->categoryId = $_GET['categoryId'];
        $result = $post->read_category_and_author($categoryId, $authorId);
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
    } else {
        $posts_arr['data'] = array();
        $post_item = array(
            'id' => '',
            'quote' => 'No Results',
            'category_name' => '',
            'author_name' => '',
        );
        array_push($posts_arr['data'], $post_item);
    }

    if(true) {
        $auth_arr = array();
        $auth_arr['data'] = array();

        while($row = $auth_result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $auth_item = array(
                'id' => $id,
                'author' => $author
            );

            // push to "data"
            array_push($auth_arr['data'], $auth_item);
        }
    }

    if(true) {
        $cat_arr = array();
        $cat_arr['data'] = array();

        while($row = $cat_result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $cat_item = array(
                'id' => $id,
                'category' => $category
            );

            // push to "data"
            array_push($cat_arr['data'], $cat_item);
        }
    }
    
    include('view/quotes_list.php');
} else if ($action == 'order_by') {
    $authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
    $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);

    header("Location: ?authorId=$authorId&categoryId=$categoryId");
}