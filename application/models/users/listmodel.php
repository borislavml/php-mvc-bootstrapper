<?php


class ListModel {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function get_users(){
        $query = $this->db->prepare("CALL sp_get_users_list()");
        $query->execute();
        
        return $query->fetchAll(); 
    }
}