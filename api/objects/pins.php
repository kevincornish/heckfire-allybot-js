<?php
class Ally{
    private $conn;
    private $table_name = "pins";
 
    public $id;
    public $clan;
    public $x;
    public $y;
    public $realm;
    public $server;
 
    public function __construct($db){
        $this->conn = $db;
    }
    // read allies
function read(){
 
  $query = "SELECT
             id, clan, x, y, realm
          FROM
              " . $this->table_name . " 
          ORDER BY
              clan DESC";

  $stmt = $this->conn->prepare($query);
  $stmt->execute();

  return $stmt;
}

// search allies
function search($keywords, $server){
 
  $query = "SELECT
              id, clan, x, y, realm, server
          FROM
              " . $this->table_name . "
          WHERE
              realm = ?
            AND
            server = ?
          ORDER BY
              clan DESC";

  $stmt = $this->conn->prepare($query);
  $keywords=htmlspecialchars(strip_tags($keywords));
  $server=htmlspecialchars(strip_tags($server));
 // $keywords = "%{$keywords}%";

  $stmt->bindParam(1, $keywords);
  $stmt->bindParam(2, $server);

  $stmt->execute();

  return $stmt;
}

// delete the ally
function delete(){
 
  // delete query
  $query = "DELETE FROM " . $this->table_name . " WHERE clan = ? AND server = ?";

  // prepare query
  $stmt = $this->conn->prepare($query);

  // sanitize
  $this->clan=htmlspecialchars(strip_tags($this->clan));
  $this->server=htmlspecialchars(strip_tags($this->server));

  // bind id of ally to delete
  $stmt->bindParam(1, $this->clan);
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
          clan=:clan, x=:x, y=:y, realm=:realm, server=:server ";
  // prepare query
  $stmt = $this->conn->prepare($query);

  // sanitize
  $this->clan=htmlspecialchars(strip_tags($this->clan));
  $this->x=htmlspecialchars(strip_tags($this->x));
  $this->y=htmlspecialchars(strip_tags($this->y));
  $this->realm=htmlspecialchars(strip_tags($this->realm));
  $this->server=htmlspecialchars(strip_tags($this->server));

  // bind values
  $stmt->bindParam(":clan", $this->clan);
  $stmt->bindParam(":x", $this->x);
  $stmt->bindParam(":y", $this->y);
  $stmt->bindParam(":realm", $this->realm);
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
          x = :x,
          y = :y,
          WHERE
          clan = :clan
		  AND
		  server = :server";

  // prepare query statement
  $stmt = $this->conn->prepare($query);

  // sanitize
  $this->x=htmlspecialchars(strip_tags($this->x));
  $this->y=htmlspecialchars(strip_tags($this->y));
  $this->clan=htmlspecialchars(strip_tags($this->clan));
  $this->server=htmlspecialchars(strip_tags($this->server));

  // bind new values
  $stmt->bindParam(':x', $this->x);
  $stmt->bindParam(':y', $this->y);
  $stmt->bindParam(':clan', $this->clan);

  // execute the query
  if($stmt->execute()){
      return true;
  }

  return false;
}

}
?>