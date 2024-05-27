<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: X-Requested-With");


require_once "config/Database.php";
require_once "controllers/CountryController.php";
$method = $_SERVER['REQUEST_METHOD'];
$countryController = new CountryController();
switch ($method) {
    case 'GET':
        $countryController->getCountries();
        break;
   /* case 'POST':
        $countryController->addCountry();
        break;
    case 'DELETE':
        $countryController->deleteCountry();
        break;
	case 'PATCH':
        $countryController->updateCountry();
        break;
		*/
    default:
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

$conn=null;