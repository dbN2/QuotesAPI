
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
        array('message' => 'Missing Required Parameters')
    );
    return;
}

//post object
if($category->create()) {
     $newCategory = array(
        'id' => $db->lastInsertId(),
        'category' => $category->category
    );
    echo json_encode($newCategory);
    http_response_code(201);
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Category Failed to Create')
    );
}

