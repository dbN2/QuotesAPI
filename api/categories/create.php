
<?php

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

//Create author object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

//check for null parameters
if(isset($data->category)) {
$category->category = $data->category;
} else{
    echo json_encode(
        array('message' => 'Could not parse JSON data')
    );
    return;
}

//post object
if($category->create()) {
    http_response_code(201);
    echo json_encode(
        array('message' => 'Category Created')
    );
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Category Failed to Create')
    );
}

