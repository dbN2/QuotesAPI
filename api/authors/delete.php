<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';


$database = new Database();
$db = $database->connect();

//Create author object
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

//check for id
if(!isset($data->id)){
    echo json_encode(array('message' => 'Missing Required Parameters')
    );
    return;
}

$author->id = $data->id;

if($author->delete()) {
    echo json_encode(array('id'=>$data->id));
} else {
    http_response_code(404);
    echo json_encode(array('message' => 'Quote with ID ' . $author->id . ' not found.'));
}

