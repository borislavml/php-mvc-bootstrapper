<?php

class Account extends Controller {

    public function login(){
              
        // handle POST request
        if (isset($_POST['login'])) {

            include_once('classes/db.php');
            include_once('lib/security.php');

            $login_model = $this->load_model('account', 'LoginModel');
            $login_model->login($_POST['email'], $_POST['password']);

            $email = $_POST['email'];
            $password = $_POST['password'];
        
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
                $db_password = DB::query("SELECT password FROM users where email=:email", array(':email'=>$email))[0]['password'];
                
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
        
        // handle GET request
        require './application/views/_templates/header.php';
        require 'application/views/account/login.php';
        require './application/views/_templates/footer.php';
    }

    public function register() {
        
        // handle post request
        if (isset($_POST['create-account'])) {

            include_once('classes/db.php');
            include_once('lib/security.php');

            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm-password'];
        
            // TODO VALIDATION
            $validation_message = ""; 
            if(empty($password)){
                $validation_message .= "Password is required";
            } else if(strlen($password) < 8 || strlen($password) > 60){
                 $validation_message .= "Password should be between 8 and 60 charachters long";   
            } else if(empty($email)) {
                $validation_message .= "Email is required";
            } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $validation_message .= "Invalid email address ".$email;
            }  else if ($password !== $confirmPassword){
                $validation_message .= "Password and confirm password don't match";
            } else if(Security::email_registered($email)) {
                $validation_message .= "Email. $email. already registred";
            }
        
            // if validation passed insert user in db
            if (empty($validation_message)) {        
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);   
        
                $sql = 'INSERT INTO users (username, email, password) VALUES(:username, :email, :password)';
                $query =  $this->db->prepare($sql);
                $query->execute(array(':username' => $email , ':email' => $email, ':password' => $hashed_password));

                // DB::query("INSERT INTO users (username, email, password) VALUES(:username, :email, :password)",
                //            array(':username'=>$email , ':email'=> $email, ':password'=>$hashed_password));
        
                // login registered user and redirect to home
                header('location: ' . URL . 'home/index');
            } else {
                echo  $validation_message;
            }
        }
        
        // handle GET request
        require './application/views/_templates/header.php';
        require 'application/views/account/register.php';
        require './application/views/_templates/footer.php';
    }

    public function logout() {
        require './application/views/_templates/header.php';
       // require 'application/views/account/logout.php';
        require './application/views/_templates/footer.php';
    }
}