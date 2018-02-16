<?php

class UserManager {
 
    public static function create_user($db, $email, $password){
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);   

        $query_insert =  $db->prepare("INSERT INTO users (username, email, password, date_registered) VALUES(:username, :email, :password, UTC_TIMESTAMP())");
        $query_insert->execute(array(':username' => $email , ':email' => $email, ':password' => $hashed_password));
        
        // return created user_id
        return $db->lastInsertId(); 
    }

    // public static function get_current_user($db) {
    //     $sql  = "SELECT * FROM users as u 
    //              JOIN users_in_roles as ur on u.user_id = ur.user_id"; 
    // }

    public static function add_user_to_role($db, $user_id, $role_id) {
        $query_insert =  $db->prepare("INSERT INTO users_in_roles (user_id, role_id) VALUES(:user_id, :role_id)");
        $query_insert->execute(array(':user_id' => $user_id, ':role_id' => $role_id));
    }

}