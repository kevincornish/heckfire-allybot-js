<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/allies.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare ally object
$ally = new Ally($db);
 
// get id of ally to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of ally to be edited
$ally->allyname = $data->allyname;
 
// set ally property values
$ally->value = $data->value;
$ally->owner = $data->owner;
$ally->clan = $data->clan;
$ally->server = $data->server;
$ally->last_update = date('Y-m-d H:i:s');
 
// update the ally
if($ally->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "ally was updated."));
}
 
// if unable to update the ally, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update ally."));
}
?>