<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

//Create author object
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

//check for id

//give the quote object existing values

//if given data, replace the object values with given values
if(!isset($data->author)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return;
}



$author->id = isset($data->id) ? $data->id : die();
$author->author = $data->author;

if($author->update()) {
    http_response_code(201);
    $newAuthor = array(
        'id' => $author->id,
        'author' => $author->author
    );
    echo json_encode($newAuthor);
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Author Failed to Update')
    );
}

