<?php

require_once "config/Database.php";
require_once "interfaces/UserInterface.php";
require_once "models/User.php";
require_once "common/responsecode.php";
require_once "constants/userConstant.php";

class UserController {
    private $user;
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user = new User($db);
    }

    public function addUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        $fullname = $data['fullname']==null?"": $data['fullname'];
        $country = $data['country']==null?"": $data['country'];
        $email = $data['email']==null?"": $data['email'];
        $password = $data['password']==null?"": $data['password'];
        if(empty($fullname)){
            http_response_code(BAD_REQUEST);
            echo json_encode(["status"=>BAD_REQUEST, "message" => INVALID_FULLNAME, "data"=>"{}"]);
        }else if(empty($email)){
            http_response_code(BAD_REQUEST);
            echo json_encode(["status"=>BAD_REQUEST, "message" => INVALID_EMAIL, "data"=>"{}"]);
        }else if(empty($country)){
            http_response_code(BAD_REQUEST);
            echo json_encode(["status"=>BAD_REQUEST, "message" => INVALID_COUNTRY, "data"=>"{}"]);
        }else if(empty($password)){
            http_response_code(BAD_REQUEST);
            echo json_encode(["status"=>BAD_REQUEST, "message" => INVALID_PASSWORD, "data"=>"{}"]);
        }else if(!($this->user->email_validation($email))){
            http_response_code(BAD_REQUEST);
            echo json_encode(["status"=>BAD_REQUEST, "message" => INVALID_EMAIL, "data"=>"{}"]);
        }else{
        if ($this->user->addUser($data)) {
            http_response_code(CREATED);
            echo json_encode(["status"=>CREATED, "message" => "User created successfully", "data"=>"{}"]);
        } else {
            http_response_code(409);
            echo json_encode(["status"=>409, "message" => "User already exists", "data"=>"{}"]);
        }
    }
    }
    public function getUsers() {
        http_response_code(200);
        echo json_encode(["status"=>200, "message" => "User fetched successfully", "data" => $this->user->getUsers()]);         
    }
    public function getUser($id) {
        http_response_code(200);
        echo json_encode(["status"=>200, "message" => "User fetched successfully", "data" => $this->user->getUser($id)]);         
    }
    public function deleteUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id']==null?"": $data['id'];
        if(empty($id)){
            http_response_code(BAD_REQUEST);
            echo json_encode(["status"=>BAD_REQUEST, "message" => INVALID_ID, "data"=>"{}"]);
        }else{
            if ($this->user->deleteUser($data)) {
                http_response_code(200);
                echo json_encode(["status"=>200, "message" => "User deleted successfully", "data"=>"{}"]);
            } else {
                http_response_code(404);
                echo json_encode(["status"=>404, "message" => "User not exists", "data"=>"{}"]);
            }
    }
    }
    public function updateUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->user->updateUser($data)) {
            http_response_code(200);
            echo json_encode(["status"=>200, "message" => "User updated successfully", "data"=>"{}"]);
        } else {
            http_response_code(404);
            echo json_encode(["status"=>404, "message" => "User not exists", "data"=>"{}"]);
           
        }
    }
    
    public function email_validation($str) { 
        return (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str))?FALSE:TRUE; 
     } 
}
?>