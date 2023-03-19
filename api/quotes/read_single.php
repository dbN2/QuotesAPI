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
$result = $quote->read_single();

if ($result !== null) {
    //Create array with object data
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author,
        'category' => $quote->category
    );

    //Return JSON
    echo json_encode($quote_arr);
} else {
    echo json_encode(array(
        'message' => 'No Quotes Found'
    ));
}