<?php

// load the optional Composer auto-loader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// load application configuration (DB, CONSTANTS, error-loging etc.)
require 'application/libs/config.php';

// load application base classes 
require 'application/libs/application.php';
require 'application/libs/controller.php';
require 'application/libs/security.php';
require 'application/libs/usermanager.php';


// start application

$app = new Application();   


//$current_user = UserManager::get_current_user($this->db);


