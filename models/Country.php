<?php
require_once "interfaces/CountryInterface.php";

class Country implements CountryInterface{
    private $conn;
    private $table_name = "countries";

    public function __construct($db) {
        $this->conn = $db;
    }
     

    public function getCountries() {
          $query = "SELECT id, country FROM " . $this->table_name;
          $statement = $this->conn->query($query)->fetchAll();
 
 
        return json_encode($statement);
    }
 
}
?>