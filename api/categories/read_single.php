<?php

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

//Create category object
$category = new Category($db);

//Get ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get category
$result = $category->read_single();

//Create array
if ($result !== null) {
    //Create array with object data
    $category_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );

    //Return JSON
    echo json_encode($category_arr);
} else {
    echo json_encode(array(
        'message' => 'category_id Not Found'
    ));
}