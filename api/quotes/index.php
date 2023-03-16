<?php

    require_once '../../models/Quote.php';
    require_once '../../models/Author.php';
    require_once '../../models/Category.php';

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    elseif($method === "GET" && isset($_GET['id'])){   //Get by id/author/category handled in read.php
        $id = $_GET['id'];
        include("read_single.php");
    }
    elseif($method === "GET"){
        include("read.php");
    }
    elseif($method === "POST" ){
        include("create.php");
    }
    elseif($method === "PUT"){
        include ("update.php");
    }
    elseif($method === "DELETE"){
        include ("delete.php");
    }

    else{
        http_response_code(404);
        echo json_encode(array("message" => "Endpoint not found."));
    }




