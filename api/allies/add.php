<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/allies.php';
 
$database = new Database();
$db = $database->getConnection();
 
$ally = new Ally($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->allyname) &&
    !empty($data->value) &&
    !empty($data->owner) &&
    !empty($data->clan) &&
    !empty($data->server)
){
 
    // set product property values
    $ally->allyname = $data->allyname;
    $ally->value = $data->value;
    $ally->owner = $data->owner;
    $ally->clan = $data->clan;
    $ally->server = $data->server;
    $ally->time_added = date('Y-m-d H:i:s');
    $ally->last_update = date('Y-m-d H:i:s');
 
    // create the product
    if($ally->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "ally was added."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to add ally."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to add ally. wrong input."));
    echo json_encode(array("allyname" => $data->allyname));
    echo json_encode(array("value" => $data->value));
    echo json_encode(array("owner" =>  $data->owner));
    echo json_encode(array("clan" =>  $data->clan));
    echo json_encode(array("server" =>  $data->server));
}
?>