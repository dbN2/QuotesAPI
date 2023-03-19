<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';


$database = new Database();
$db = $database->connect();

//Create author object
$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

//check for id
if(!isset($data->id)){
   echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return;
}

$quote->id = $data->id;

if (!$quote->read_single()) {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
    return;
}

if($quote->delete()) {
    echo json_encode(array('id'=>$data->id
    ));
         
} else {
    echo json_encode(
      array('message' => 'No Quotes Found'));
}


