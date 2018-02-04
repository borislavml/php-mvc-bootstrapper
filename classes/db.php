<?php

include_once('config/db.php');

class DB {

    private static function connect(){
        $host = DB_HOST;
        $dbName = DB_DATABASE;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;

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