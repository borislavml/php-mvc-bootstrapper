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
        } else if(!DB::query("SELECT email from users WHERE email=:email", array(':email'=> $email))) {
            $validation_message .= "Invalid email";
        }
    
        // if validation passed try loging user
        if (empty($validation_message)) {

            $sql = 'SELECT password FROM users where email=:email';
            $query = $this->db->prepare($sql);
            $query->execute(array(':email' => $email));

            $db_password = $query->fetchAll();
            //$db_password = DB::query("SELECT password FROM users where email=:email", array(':email'=>$email))[0]['password'];
            
            if(password_verify($password, $db_password)){
                // generate token, insert hashed token in DB, set token in cookie
                $token = Security::generate_token();
                $user_id  = Security::get_userid_byemail($email);
                

                $sql = 'INSERT INTO login_tokens (token, user_id) VALUES(:token, :user_id)';
                $query = $this->db->prepare($sql);
                $query->execute(array(':token' => sha1($token), ':user_id' => $user_id));

                // DB::query('INSERT INTO login_tokens (token, user_id) VALUES(:token, :user_id)', array(':token'=>sha1($token), ':user_id'=> $user_id));
                
                setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                setcookie("SNID_", 1, time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);   
                
                // redirect logged user to home
                header('location: ' . URL . 'home/index');
            } else {
                echo "Incorect password";
            }
            
        } else {
            echo  $validation_message;
        }  
        
    }
}