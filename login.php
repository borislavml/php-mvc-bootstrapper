<?php

include_once('classes/db.php');
include_once('lib/security.php');

if (isset($_POST['login'])) {
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
            
            DB::query('INSERT INTO login_tokens (token, user_id) VALUES(:token, :user_id)', array(':token'=>sha1($token), ':user_id'=> $user_id));
           
            setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
            setcookie("SNID_", 1, time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);          
        } else {
            echo "Incorect password";
        }
        
    } else {
        echo  $validation_message;
    }
}

?>

<html>
    <head>
        <link rel="stylesheet" 
              href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
              crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" 
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-2"> </div>
                <div class="col-md-4 col-sm-8"> 
                    <h1 class="text-center">Login</h1>
                </div>           
                <div class="col-md-4 col-sm-2"> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-2"></div>
                <div class="col-md-4 col-sm-8">
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                            <small id="emailHelp" class="form-text text-muted">Enter your email address</small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Enter Password" required>
                            <small id="passwordHelp" class="form-text text-muted">Enter your password</small>
                        </div>                   
                        <div class="text-center">
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>  
                <div class="col-md-4 col-sm-2"></div>
            </div>
        </div>                
    </body>
</html>


