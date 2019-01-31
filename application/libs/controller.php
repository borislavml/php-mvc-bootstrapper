<?php

// base controller class
// all controllers should derive from it
class Controller {

    // db connection
    protected $db = null;
    
    // open db connection upon controller request and use this one connection for all models
    public function __construct(){
        $this->open_db_conncetion();
    }

    public function load_model(string $model_folder, string $model_name){
        require Config::get('PATH_MODELS') . $model_folder . '/' . strtolower($model_name) . '.php';
        
        //  pass db connetion to model and return it
        return new $model_name($this->db);
    }

    private function open_db_conncetion(){
     // set oprtions fro PDO connection -> fetch results as objects
     // @see http://www.php.net/manual/en/pdostatement.fetch.php
     $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

     // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
     $this->db = new PDO(Config::get('DB_TYPE') . ':host=' . Config::get('DB_HOST') . ';dbname=' . Config::get('DB_NAME'), Config::get('DB_USER'), Config::get('DB_PASS'), $options);    
    }
}



