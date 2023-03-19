
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
        array('message' => 'Missing Required Parameters')
    );
    return;
}

//post object
if($author->create()) {
     $newAuthor = array(
        'id' => $db->lastInsertId(),
        'author' => $author->author
    );
    echo json_encode($newAuthor);
    http_response_code(201);
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Author Failed to Create')
    );
}

