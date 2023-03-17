<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

//Create quote object
$quote = new Quote($db);

//Get ID
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get quote 
$quote->read_single();

//Create array with object data
$quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author_id' => $quote->author_id,
    'category_id' => $quote->category_id
);

//Return JSON
print_r(json_encode($quote_arr));