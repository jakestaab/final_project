<?php
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

    $authors = Author::get_authors();
    $categories = Category::get_categories();
    include('view/quotes_list.php');
}