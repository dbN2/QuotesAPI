<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

//Create author object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

//check for id

//give the quote object existing values

//if given data, replace the object values with given values
if(!isset($data->category)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return;
}



$category->id = isset($data->id) ? $data->id : die();
$category->category = $data->category;

if($category->update()) {
    http_response_code(201);
    $newCategory = array(
        'id' => $category->id,
        'category' => $category->category
    );
    echo json_encode($newCategory);
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Category Failed to Update')
    );
}

