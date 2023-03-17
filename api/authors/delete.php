<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';


$database = new Database();
$db = $database->connect();

//Create author object
$author = new Author($db);

//check for id
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

if($author->delete()) {
    http_response_code(204);
    echo json_encode(
        array('message' => 'Successfully deleted')
    );
} else {
    http_response_code(404);
    echo json_encode(array('message' => 'Quote with ID ' . $author->id . ' not found.'));
}

