<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

//Create author object
$author = new Author($db);

//Get ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get author
$result = $author->read_single();

//Create array
if ($result !== null) {
    //Create array with object data
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    );

    //Return JSON
    echo json_encode($author_arr);
} else {
    echo json_encode(array(
        'message' => 'author_id Not Found'
    ));
}