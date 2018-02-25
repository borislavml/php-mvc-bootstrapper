<?php

class RegisterModel {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function register($email, $password, $confirmPassword) {        
        // TODO VALIDATION
        $validation_message = ""; 
        if(empty($password)){
            $validation_message .= "Password is required";
        } else if(strlen($password) < 8 || strlen($password) > 20){
                $validation_message .= "Password should be between 8 and 20 charachters long";   
        } else if(empty($email)) {
            $validation_message .= "Email is required";
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $validation_message .= "Invalid email address format ".$email;
        }  else if ($password !== $confirmPassword){
            $validation_message .= "Password and confirm password don't match";
        } else if(Security::is_email_registered($this->db, $email)) {
            $validation_message .= "Email. $email. already registred";
        }
    
        // if validation passed insert user in db
        if (empty($validation_message)) {        

            // create user and to default consumer role
            $user_id = UserManager::create_user($this->db, $email, $password); 
            UserManager::add_user_to_role($this->db, $user_id, Config::get('ROLE_CONSUMER'));

            // login registered user and redirect to home
            Security::login($this->db,  $email);
            header('location: ' . Config::get('URL') . 'home/index');
        } 

        return  $validation_message;       
    }
}