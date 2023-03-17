<?php

include_once '../../config/Database.php';
include_once '../../models/Category.php';


$database = new Database();
$db = $database->connect();

//Create author object
$category = new Category($db);

//check for id
$category->id = isset($_GET['id']) ? $_GET['id'] : die();


if($category->delete()) {
    http_response_code(204);
    echo json_encode(
        array('message' => 'Successfully deleted')
    );
} else {
    http_response_code(404);
    echo json_encode(array('message' => 'Quote with ID ' . $category->id . ' not found.'));
}

