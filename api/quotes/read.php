<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

//Create quote object
$quote = new Quote($db);

//Check for parameters
$quote->author_id = isset($_GET['authorId'])? $_GET['authorId'] : null;
$quote->category_id = isset($_GET['categoryId'])? $_GET['categoryId'] : null;

$result;

//Get all quotes from an author
if($quote->author_id!==null && $quote->category_id ===null){

    $result = $quote->read_author();

}

//Get all quotes in a category
elseif($quote->author_id ===null && $quote->category_id!==null){

    $result = $quote->read_category();
}

//Get all quotes in a category by an author
elseif($quote->author_id!==null && $quote->category_id!==null){

    $result = $quote->read_author_category();
}

//Get all quotes
else{
$result = $quote->read();
}

//get data and print it
if ($result->rowCount() > 0) {
    $quote_arr = array();
    $quote_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category
        );
        array_push($quote_arr['data'], $quote_item);
    }
    http_response_code(200);
    echo json_encode($quote_arr['data']);
} else{
  echo json_encode(array(
    'message' => 'No Quotes Found'));
}



