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


if($action == 'list_quotes') {

    
    include('view/quotes_list.php');
} else if ($action == 'order_by') {
    $authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
    $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);

    header("Location: ?authorId=$authorId&categoryId=$categoryId");
}