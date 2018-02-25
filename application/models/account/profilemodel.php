<?php


class ProfileModel  {
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function get_profile() {
        $user_id = Security::get_current_userid($this->db);

        $query = $this->db->prepare("SELECT id, email, username, date_registered FROM users where id=:id");
        $query->execute(array(":id" => $user_id));
        
        $result = $query->fetchAll();

        return isset($result[0]) ? $result[0] : null;
    }

    public function change_password($user_id, $current_password, $new_password, $confirm_password) {
        $validation_message = ""; 

        if(!UserManager::verify_password($this->db, $user_id, $current_password)){
            $validation_message .= "Invalid current password";
        } else if(empty($new_password) || empty($current_password)){
            $validation_message .= "Password is required";
        } else if(strlen($new_password) < 8 || strlen($new_password) > 20){
             $validation_message .= "Password should be between 8 and 20 charachters long";   
        } else if ($new_password !== $confirm_password){
            $validation_message .= "Password and confirm password don't match";
        } 
        
        if (empty($validation_message)) {        
            $result =  UserManager::set_password($this->db, $user_id, $new_password);
            if (!$result) {
                $validation_message = "Error trying to change password";
            } 
        } 

        return $validation_message;    
    }

}