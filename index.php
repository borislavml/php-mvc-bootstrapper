<?php

// load the optional Composer auto-loader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// load application configuration (DB, error-loging etc/)
require 'application/config/config.php';

// load application base classes 
require 'application/libs/application.php';
require 'application/libs/controller.php';

// start application
$app = new Application();   


// include_once('lib/security.php');

// $username = 'anonymous';
// $user_id = '';
// $isLogged = Security::is_logged(); 
// if ($isLogged) {
//     $user_id = Security::get_userid();
//     $username = Security::get_username();
// }

