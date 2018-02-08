<?php

include_once('classes/db.php');
include_once('lib/security.php');

if (isset($_POST['create-account'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // TODO VALIDATION
    $validation_message = ""; 
    if(empty($password)){
        $validation_message .= "Password is required";
    } else if(strlen($password) <8 || strlen($password) > 60){
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

        DB::query("INSERT INTO users (username, email, password) VALUES(:username, :email, :password)",
                   array(':username'=>$email , ':email'=> $email, ':password'=>$hashed_password));

        echo "sucess";
    } else {
        echo  $validation_message;
    }
}

?>

<!DOCTYPE html>
<html lang="eng">
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
                    <h1 class="text-center">Register</h1>
                </div>           
                <div class="col-md-4 col-sm-2"> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-2"></div>
                <div class="col-md-4 col-sm-8">
                    <form action="create-account.php" method="post">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                            <small id="emailHelp" class="form-text text-muted">Provide an email address</small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Enter Password" required>
                            <small id="passwordHelp" class="form-text text-muted">Provide a secure password</small>
                        </div>
                        <div class="form-group">
                            <label for="passwordConfirm">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm-password" id="passwordConfirm" aria-describedby="passwordConfirmHelp" placeholder="Confirm Password" required>
                            <small id="passwordConfirmHelp" class="form-text text-muted">Confirm your password</small>
                        </div>                      
                        <div class="text-center">
                            <button type="submit" name="create-account" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>  
                <div class="col-md-4 col-sm-2"></div>
            </div>
        </div>                
    </body>
</html>


