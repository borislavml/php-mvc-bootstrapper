<?php

class UserModel {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch(PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function get_user($id) {
        $query = $this->db->prepare("SELECT id, email, username, date_registered FROM users where id=:id");
        $query->execute(array(":id" => $id));
        $result = $query->fetchAll();

        return isset($result[0]) ? $result[0] : null;
    }

    public function get_roles($id) {
        $query = $this->db->prepare("SELECT role_id FROM users_in_roles where user_id=:id");
        $query->execute(array(":id" => $id));
        
        return $query->fetchAll();
    }

    public function edit_roles($user_id, $admin_role) {
        $edit_role_result = false; 

        // get all roles except consumer because its immutable
        $current_user_roles = $this->get_roles($user_id);
        $user_roles_ids = array_map('reset', $current_user_roles);
        
        $admin_role_id = Config::get('ROLE_ADMIN');
        $admin_role_set = filter_var($admin_role, FILTER_VALIDATE_BOOLEAN);

        //if current user has amin role and amin role is false - romve user from role
        // else if current user doesn'have admin role and admin role is true - add user to role
        if(in_array($admin_role_id, $user_roles_ids) && !$admin_role_set) {
            $edit_role_result =  UserManager::remove_user_from_role($this->db, $user_id, $admin_role_id);
        } else if(!in_array($admin_role_id, $user_roles_ids) && $admin_role_set) {
            $edit_role_result = UserManager::add_user_to_role($this->db, $user_id, $admin_role_id);
        }

        return $edit_role_result;
    }

    public function change_password($user_id, $new_password, $confirm_password) {
        $validation_message = ""; 
        if(empty($new_password)){
            $validation_message .= "Password is required";
        } else if(strlen($new_password) < 8 || strlen($new_password) > 20){
             $validation_message .= "Password should be between 8 and 20 charachters long";   
        } else if ($new_password !== $confirm_password){
            $validation_message .= "Password and confirm password don't match";
        } 
    
        // if validation passed insert user in db
        if (empty($validation_message)) {        
            $result =  UserManager::set_password($this->db, $user_id, $new_password);
            if (!$result) {
                $validation_message = "Error trying to change user password";
            } 
        } 

        return  $validation_message;    
    }
}