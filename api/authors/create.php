
<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

//Create author object
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

//check for null parameters
if(isset($data->author)) {
$author->author = $data->author;
} else{
    echo json_encode(
        array('message' => 'Could not parse JSON data')
    );
    return;
}

//post object
if($author->create()) {
    http_response_code(201);
    echo json_encode(
        array('message' => 'Author Created')
    );
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Author Failed to Create')
    );
}

