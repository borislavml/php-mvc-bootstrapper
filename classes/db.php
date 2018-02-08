<?php

include_once('application/config/config.php');

class DB {

    private static function connect(){
        $host = DB_HOST;
        $dbName = DB_NAME;
        $username = DB_USER;
        $password = DB_PASS;

        $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public static function query($query, $params = array()){
        $statement = self::connect()->prepare($query);
        $statement->execute($params);

        if (explode(' ', $query)[0] == 'SELECT') {         
            $data = $statement->fetchall();
            return $data;
        }
    }

}

?>