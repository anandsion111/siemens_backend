<?php

class Database {
  private $port = 3306;
  private $host = "localhost";
  private $username = "root";
  private $password = "";
  private $db_name = "siemens";

  public $conn;

public function getConnection() {

  $this->conn = null;

try {

   

  $this->conn = new PDO("mysql:host=". $this->host.";dbname=". $this->db_name, $this->username, $this->password);

  $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

 // echo "Connected successfully";

} catch(PDOException $e) {

  echo "Connection failed: " . $e->getMessage();

}

 return $this->conn;

  }

}