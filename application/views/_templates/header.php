<?php $user_is_logged = Security::is_logged($this->db); ?>

<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PHP MVC skeleton</title>
        <meta name="description" content="PHP MVC">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" 
              href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
              crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo Config::get('URL');?>public/css/site.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" 
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>
        <script src="<?php echo Config::get('URL'); ?>public/js/site.js"></script>
    </head>
    <body>
        <!-- navbar-menu start -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="<?php echo Config::get('URL'); ?>">PHP-MVC</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php if(!$user_is_logged) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo Config::get('URL'); ?>account/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo Config::get('URL'); ?>account/register">Register</a>
                        </li> 
                    <?php } else { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" 
                            id="navbarDropdown"
                            role="button" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false"> <?php  echo Security::get_username($this->db);?></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <form action="<?php echo Config::get('URL'); ?>account/logout" 
                                      method="POST" 
                                      id="logout-form" 
                                      class="form-inline">
                                    <a class="dropdown-item" name="logout"  href="javascript:void(0)">Logout</a>          
                                </form> 
                            </div>
                         </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <!-- navbar-menu end -->
        <!-- main start -->
        <div class="container-fluid" style="padding:5px">
          <div class="row">                    
            







