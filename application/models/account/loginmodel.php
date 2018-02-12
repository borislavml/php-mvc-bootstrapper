<?php

class Loginmodel {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function login($email, $password) {
        // TODO VALIDATION
        $validation_message = ""; 
        if(empty($password)){
            $validation_message .= "Please provide a password";
        } else if(empty($email)) {
            $validation_message .= "Please provide an email addrrss";
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $validation_message .= "Invalid email address ".$email;
        } else if(!Security::is_email_registered($this->db, $email)) {
            $validation_message .= "Invalid email";
        }
    
        // if validation passed try loging user
        if (empty($validation_message)) {
            $query = $this->db->prepare("SELECT password FROM users where email=:email");
            $query->execute(array(':email' => $email));
            $db_password = $query->fetchAll()[0]->password;

            if(password_verify($password, $db_password)){
                // generate token, insert hashed token in DB, set token in cookie
                $token = Security::generate_token($this->db);
                $user_id  = Security::get_userid_byemail($this->db, $email);
            
                $query_insert = $this->db->prepare("INSERT INTO login_tokens (token, user_id) VALUES(:token, :user_id)");
                $query_insert->execute(array(':token' => sha1($token), ':user_id' => $user_id));

                setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                setcookie("SNID_", 1, time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);   
                
                // we're all good, redirect logged user to home
                header('location: ' . URL . 'home/index');
            } else {
                $validation_message .= "Invaid password";
            }            
        } 
        
        // if we fell through here login was not successfull - return error message to page
        return $validation_message;
    }
}