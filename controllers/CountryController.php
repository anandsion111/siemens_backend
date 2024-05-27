<?php

require_once "config/Database.php";
require_once "interfaces/CountryInterface.php";
require_once "models/Country.php";
require_once "common/responsecode.php";
require_once "constants/countryConstant.php";

class CountryController {
    private $country;
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->country = new Country($db);
    }

     
    public function getCountries() {
        http_response_code(200);
        echo json_encode(["status"=>200, "message" => "Country fetched successfully", "data" => $this->country->getCountries()]);         
    } 
}
?>