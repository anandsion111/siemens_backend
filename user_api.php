<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: X-Requested-With");


require_once "config/Database.php";
require_once "controllers/UserController.php";
$method = $_SERVER['REQUEST_METHOD'];
$userController = new UserController();
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $userController->getUser($_GET['id']);
        }else {
          $userController->getUsers();
        }
        break;
    case 'POST':
        $userController->addUser();
        break;
    case 'DELETE':
        $userController->deleteUser();
        break;
	case 'PATCH':
        $userController->updateUser();
        break;
    default:
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

$conn=null;