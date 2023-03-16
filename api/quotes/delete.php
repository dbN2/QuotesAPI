<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';


$database = new Database();
$db = $database->connect();

//Create author object
$quote = new Quote($db);

//check for id
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();


if($quote->delete()) {
    http_response_code(204);
    echo json_encode(
        array('message' => 'Successfully deleted')
    );
} else {
    http_response_code(404);
    echo json_encode(array('message' => 'Quote with ID ' . $quote->id . ' not found.'));
}

