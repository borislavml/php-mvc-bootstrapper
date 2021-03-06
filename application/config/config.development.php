<?php


/**
 * Configuration for DEVELOPMENT environment
 * To create another configuration set just copy this file to config.production.php etc.
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard / no errors in production.
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configuration for cookie security
 *  Marks the cookie as accessible only through HTTP (no JS)
 */
ini_set('session.cookie_httponly', 1);

/**
 * Returns the full configuration.
 * This is used by the Libs/Config class.
 */
return array (
    'URL' => 'http://localhost/php-mvc-bootstrapper/',
    
    /** 
     * MVC related 
     * */
    'PATH_CONTROLLERS' => './application/controllers/',
    'PATH_MODELS' => 'application/models/',
    'PATH_VIEWS' => './application/views/',
    'PATH_VIEWS_TEMPLATES' => './application/views/_templates/',
    'DEFAULT_CONTROLLER' => 'home',
    'DEFAULT_ACTION' => 'index',

    /** 
     * DB related 
     * */
    'DB_TYPE' => 'mysql',
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'bootstrap',
    'DB_USER' => 'root' ,
    'DB_PASS' => '',   

    /**
     * DB user roles 
     */
    'ROLE_ADMIN' => 2,
    'ROLE_CONSUMER' => 1,

    /**
     * DB permisions groups
     * 
     */
);






