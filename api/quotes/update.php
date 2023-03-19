<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

//Create author object
$quote = new Quote($db);
$author = new Author($db);
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

//check for id

//give the quote object existing values

//if given data, replace the object values with given values
if(!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return;
}

//check if author exists
$author->id = $data->author_id;
if (!$author->read_single()) {
    echo json_encode(
        array('message' => 'author_id Not Found')
    );
    return;
}
//check if category exists
$category->id = $data->category_id;
if (!$category->read_single()) {
    echo json_encode(
        array('message' => 'category_id Not Found')
    );
    return;
}
//check that id is given
$quote->id = isset($data->id) ? $data->id : die();

//check if quote with id exists
if(!$quote->read_single()){
  echo json_encode(
    array('message' => 'No Quotes Found')
  );
  return;
}

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;


if($quote->update()) {
    http_response_code(201);
    $newQuote = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id
    );
    echo json_encode($newQuote);
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Quote Failed to Update')
    );
}

