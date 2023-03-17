<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

//Create author object
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

//check for id
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

//give the object existing values
$author->read_single();

//if given data replace values
if(isset($data->author)) {
    $author->author = $data->author;
} 

if($author->update()) {
    http_response_code(201);
    echo json_encode(
        array('message' => 'Author Updated')
    );
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Author Failed to Update')
    );
}

