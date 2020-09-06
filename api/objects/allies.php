<?php
class Ally{
    private $conn;
    private $table_name = "allies";
 
    public $id;
    public $allyname;
    public $value;
    public $owner;
    public $clan;
    public $time_added;
    public $last_update;
    public $server;
 
    public function __construct($db){
        $this->conn = $db;
    }
    // read allies
function read(){
 
  $query = "SELECT
             id, allyname, value, owner, clan, time_added, last_update
          FROM
              " . $this->table_name . " 
          ORDER BY
              last_update DESC";

  $stmt = $this->conn->prepare($query);
  $stmt->execute();

  return $stmt;
}

// search allies
function search($keywords, $server){
 
  $query = "SELECT
              id, allyname, value, owner, clan, time_added, last_update, server
          FROM
              " . $this->table_name . "
          WHERE
              owner = ?
          AND
              server = ?
          ORDER BY
              last_update DESC";

  $stmt = $this->conn->prepare($query);
  $keywords=htmlspecialchars(strip_tags($keywords));
  $server=htmlspecialchars(strip_tags($server));
 // $keywords = "%{$keywords}%";

  $stmt->bindParam(1, $keywords);
  $stmt->bindParam(2, $server);

  $stmt->execute();

  return $stmt;
}
// search value
function value($keywords, $server){
 
  $query = "SELECT
              id, allyname, value, owner, clan, time_added, last_update, server
          FROM
              " . $this->table_name . "
          WHERE
              value = ?
              AND
              server = ?
          ORDER BY
              last_update DESC";

  $stmt = $this->conn->prepare($query);
  $keywords=htmlspecialchars(strip_tags($keywords));
  $server=htmlspecialchars(strip_tags($server));
  //$keywords = "%{$keywords}%";

  $stmt->bindParam(1, $keywords);
  $stmt->bindParam(2, $server);

  $stmt->execute();

  return $stmt;
}
// search clans
function owners($keywords, $server){
 
  $query = "SELECT
              DISTINCT(owner), clan, server
          FROM
              " . $this->table_name . "
                        WHERE
                        clan = ?
                        AND
                        server = ?";

  $stmt = $this->conn->prepare($query);
  $keywords=htmlspecialchars(strip_tags($keywords));
  $server=htmlspecialchars(strip_tags($server));
 // $keywords = "%{$keywords}%";

  $stmt->bindParam(1, $keywords);
  $stmt->bindParam(2, $server);

  $stmt->execute();

  return $stmt;
}
// search clans
function oldest($keywords, $server){
 
  $query = "SELECT
              allyname, value, last_update, clan, owner
          FROM
              " . $this->table_name . "
                        WHERE
                        clan = ?
                        AND
                        server ? LIMIT 10";

  $stmt = $this->conn->prepare($query);
  $keywords=htmlspecialchars(strip_tags($keywords));
  $server=htmlspecialchars(strip_tags($server));
 // $keywords = "%{$keywords}%";

  $stmt->bindParam(1, $keywords);
  $stmt->bindParam(2, $server);

  $stmt->execute();

  return $stmt;
}
// list all clans
function clanlist($server){
 
  $query = "SELECT DISTINCT 
              clan
          FROM
              " . $this->table_name . " WHERE server = ?";

  $stmt = $this->conn->prepare($query);
  $server=htmlspecialchars(strip_tags($server));
$stmt->bindParam(1, $server);
  $stmt->execute();

  return $stmt;
}
// read allies with pagination
public function readPaging($from_record_num, $records_per_page){
 

  $query = "SELECT
  id, allyname, value, owner, clan, time_added, last_update
FROM
  " . $this->table_name . "
          ORDER BY last_update ASC
          LIMIT ?, ?";

  $stmt = $this->conn->prepare( $query );

  $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
  $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt;
}
// used for paging allies
public function count(){
  $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

  $stmt = $this->conn->prepare( $query );
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  return $row['total_rows'];
}

// delete the ally
function delete(){
 
  // delete query
  $query = "DELETE FROM " . $this->table_name . " WHERE allyname = ? AND server = ?";

  // prepare query
  $stmt = $this->conn->prepare($query);

  // sanitize
  $this->allyname=htmlspecialchars(strip_tags($this->allyname));
  $this->server=htmlspecialchars(strip_tags($this->server));

  // bind id of ally to delete
  $stmt->bindParam(1, $this->allyname);
  $stmt->bindParam(2, $this->server);

  // execute query
  if($stmt->execute()){
      return true;
  }

  return false;
   
}

// create ally
function create(){
 
  // query to insert ally
  $query = "INSERT INTO
              " . $this->table_name . "
          SET
          allyname=:allyname, value=:value, owner=:owner, clan=:clan, time_added=:time_added, last_update=:last_update,server=:server ";
  // prepare query
  $stmt = $this->conn->prepare($query);

  // sanitize
  $this->allyname=htmlspecialchars(strip_tags($this->allyname));
  $this->value=htmlspecialchars(strip_tags($this->value));
  $this->owner=htmlspecialchars(strip_tags($this->owner));
  $this->clan=htmlspecialchars(strip_tags($this->clan));
  $this->time_added=htmlspecialchars(strip_tags($this->time_added));
  $this->last_update=htmlspecialchars(strip_tags($this->last_update));
  $this->server=htmlspecialchars(strip_tags($this->server));

  // bind values
  $stmt->bindParam(":allyname", $this->allyname);
  $stmt->bindParam(":value", $this->value);
  $stmt->bindParam(":owner", $this->owner);
  $stmt->bindParam(":clan", $this->clan);
  $stmt->bindParam(":time_added", $this->time_added);
  $stmt->bindParam(":last_update", $this->last_update);
  $stmt->bindParam(":server", $this->server);

  // execute query
  if($stmt->execute()){
      return true;
  }

  return false;
   
}

// update the product
function update(){
 
  // update query
  $query = "UPDATE
              " . $this->table_name . "
          SET
          value = :value,
          owner = :owner,
          clan = :clan,
          last_update = :last_update 
          WHERE
          allyname = :allyname
          AND
          server = :server";

  // prepare query statement
  $stmt = $this->conn->prepare($query);

  // sanitize
  $this->value=htmlspecialchars(strip_tags($this->value));
  $this->owner=htmlspecialchars(strip_tags($this->owner));
  $this->clan=htmlspecialchars(strip_tags($this->clan));
  $this->last_update=htmlspecialchars(strip_tags($this->last_update));
  $this->allyname=htmlspecialchars(strip_tags($this->allyname));
  $this->server=htmlspecialchars(strip_tags($this->server));

  // bind new values
  $stmt->bindParam(':value', $this->value);
  $stmt->bindParam(':owner', $this->owner);
  $stmt->bindParam(':clan', $this->clan);
  $stmt->bindParam(":last_update", $this->last_update);
  $stmt->bindParam(':allyname', $this->allyname);
  $stmt->bindParam(':server', $this->server);

  // execute the query
  if($stmt->execute()){
      return true;
  }

  return false;
}

}
?>