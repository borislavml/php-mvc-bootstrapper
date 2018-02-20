<?php

class UserModel {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch(PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function get_user($id) {
        $query = $this->db->prepare("SELECT id, email, username, date_registered FROM users where id=:id");
        $query->execute(array(":id" => $id));
        $result = $query->fetchAll();

        return isset($result[0]) ? $result[0] : null;
    }
}