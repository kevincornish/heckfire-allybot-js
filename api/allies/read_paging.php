<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/allies.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and ally object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$ally = new Ally($db);
 
// query ally
$stmt = $ally->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // ally array
    $ally_arr=array();
    $ally_arr["records"]=array();
    $ally_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $ally_item=array(
          "id" => $id,
          "allyname" => $allyname,
          "value" => $value,
          "owner" => $owner,
          "clan" => $clan,
          "time_added" => $time_added,
          "last_update" => $last_update
      );
 
        array_push($ally_arr["records"], $ally_item);
    }
 
 
    // include paging
    $total_rows=$ally->count();
    $page_url="{$home_url}allies/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $ally_arr["paging"]=$paging;
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($ally_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user ally does not exist
    echo json_encode(
        array("message" => "No allies found.")
    );
}
?>