<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

//Create author object
$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

//check if parameters are null
if(!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(
        array('message' => 'Null parameters not allowed. Please enter quote, author_id, and category_id.')
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
    echo json_encode(
        array('message' => 'Quote Created')
    );
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Quote Failed to Create')
    );
}

