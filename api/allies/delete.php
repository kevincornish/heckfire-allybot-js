<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/allies.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare ally object
$ally = new Ally($db);
 
// get ally id
$data = json_decode(file_get_contents("php://input"));
 
// set ally id to be deleted
$ally->allyname = $data->allyname;
$ally->server = $data->server;
 
// delete the ally
if($ally->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "ally was deleted."));
}
 
// if unable to delete the ally
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete ally."));
}
?>