<?php
require_once "interfaces/UserInterface.php";

class User implements UserInterface{
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }
    public function addUser($data) {
        
                $fullname = $data['fullname'];
                $country = $data['country'];
                $email = $data['email'];
                $password = md5($data['password']);

                $query_check_user = "SELECT *  FROM " . $this->table_name. " WHERE email =:email";
                $checkExist = $this->conn->prepare($query_check_user); 
                $checkExist->execute([':email'=>$email]); 
                if($checkExist->rowCount()==0){
                    $sql = "INSERT INTO " . $this->table_name. " (fullname, email, password, country_id) VALUES (:fullname, :email, :password, :country_id )";
                    $statement = $this->conn->prepare($sql);
                    $status = $statement->execute(['fullname'=>$fullname,'email'=>$email,'password'=>$password, "country_id"=>$country]);
               if ($status) {
                  return true;
                } 
            }else{
                return false;
            }
            return false;
        
        
    }

    public function getUsers() {
          $query = "SELECT u.id, u.fullname, u.email, u.country_id, c.country FROM " . $this->table_name." u LEFT JOIN countries c ON u.country_id=c.id";
          $statement = $this->conn->query($query)->fetchAll();
 
 
        return json_encode($statement);
    }

    public function getUser($id) {
        $query = "SELECT u.id, u.fullname, u.email, u.country_id, c.country FROM " . $this->table_name." u LEFT JOIN countries c ON u.country_id=c.id WHERE u.id='".$id."'";
        $statement = $this->conn->query($query)->fetchAll();


      return json_encode($statement);
  }

    public function deleteUser($data) {
        
        echo $id = $data['id'];
        $query_check_user = "SELECT *  FROM " . $this->table_name. " WHERE id =:id";
        $checkExist = $this->conn->prepare($query_check_user); 
        $checkExist->execute([':id'=>$id]); 
        if($checkExist->rowCount()>0){
            $sql = "DELETE FROM users where id =:id";
            $statement = $this->conn->prepare($sql);
            $status = $statement->execute(['id'=>$id]);
       if ($status) {
          return true;
        } 
    }else{
        return false;
    }
    return false;
}
 
public function updateUser($data) {
        
    $fullname = $data['fullname'];
    $country = $data['country'];
    $id = $data['id'];
    $query_check_user = "SELECT *  FROM " . $this->table_name. " WHERE id =:id";
    $checkExist = $this->conn->prepare($query_check_user); 
    $checkExist->execute([':id'=>$id]); 
    if($checkExist->rowCount()>0){
        $sql = "UPDATE " . $this->table_name. " SET fullname=:fullname, country_id=:country_id  WHERE id = :id";
        $statement = $this->conn->prepare($sql);
        $status = $statement->execute(['fullname'=>$fullname, "country_id"=>$country, 'id'=>$id,]);
   if ($status) {
      return true;
    } 
}else{
    return false;
}
return false;


}

}
?>