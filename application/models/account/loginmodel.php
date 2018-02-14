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
                Security::login($this->db, $email);                
                // redirect logged user to home
                header('location: ' . Config::get('URL') . 'home/index');
            } else {
                $validation_message .= "Invaid password";
            }            
        } 
        
        // if we fell through here login was not successfull - return error message to page
        return $validation_message;
    }
}