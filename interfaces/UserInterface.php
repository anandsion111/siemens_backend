<?php
 interface UserInterface {
    public function addUser($data);
    public function getUsers();
    public function getUser($id);
    public function deleteUser($data);
    public function updateUser($data);
    public function email_validation($email);
 }
?>