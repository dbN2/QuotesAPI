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
$category->read_single();

//Create array
$category_arr = array(
    'id' => $category->id,
    'category' => $category->category
);

//Return JSON
print_r(json_encode($category_arr));