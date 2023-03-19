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

//check if parameters are null
if(!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return;
}

$author->id = $data->author_id;
if (!$author->read_single()) {
    echo json_encode(
        array('message' => 'author_id Not Found')
    );
    return;
}

$category->id = $data->category_id;
if (!$category->read_single()) {
    echo json_encode(
        array('message' => 'category_id Not Found')
    );
    return;
}

//set object values
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

//post object
if($quote->create()) {
    http_response_code(201);
     $newQuote = array(
        'id' => $db->lastInsertId(),
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id
    );
    echo json_encode($newQuote);
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Quote Failed to Create')
    );
}

