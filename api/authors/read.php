<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

//Create category object
$author = new Author($db);

//Get categories 
$result = $author->read();

if($result->rowCount() > 0){
    $author_arr = array();
    $author_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $author_item = array(
            'id' => $id,
            'author' => $author
        );
        array_push($author_arr['data'], $author_item);
    
    }
    echo json_encode($author_arr);

} else { 
    echo json_encode(
        array('message' => 'No Authors Found')
    );
}

    
