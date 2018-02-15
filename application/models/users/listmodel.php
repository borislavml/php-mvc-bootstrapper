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
        $query = $this->db->prepare("SELECT id, username, email FROM users");
        $query->execute();

        return $query->fetchAll();
    }
}