<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

//Create author object
$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

//check for id
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

//give the quote object existing values
$quote->read_single();

//if given data, replace the object values with given values
if(isset($data->quote)) {
    $quote->quote = $data->quote;
} 
if(isset($data->author_id)) {
$quote->author_id = $data->author_id;
}
if(isset($data->category_id)) {
    $quote->category_id = $data->category_id;
}

if($quote->update()) {
    http_response_code(201);
    echo json_encode(
        array('message' => 'Quote Updated')
    );
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Quote Failed to Update')
    );
}

