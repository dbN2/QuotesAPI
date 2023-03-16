<?php

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

//Create author object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

//check for id
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

//give the object existing values
$category->read_single();

//if given data replace values
if(isset($data->category)) {
    $category->category = $data->category;
} 

if($category->update()) {
    http_response_code(201);
    echo json_encode(
        array('message' => 'Category Updated')
    );
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Category Failed to Update')
    );
}

