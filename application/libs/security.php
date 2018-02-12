<?php

class Security {

    public static function generate_token() {
        $crypto_strong  = True;
        return bin2hex(openssl_random_pseudo_bytes(64, $crypto_strong));
    }

    public static function get_userid_byemail($db, $email){
        $query = $db->prepare("SELECT id FROM users WHERE email=:email");
        $query->execute(array(":email" => $email));

        return  $query->fetchAll()[0]->id;
    }

    public static function get_userid($db){
        if (isset($_COOKIE['SNID'])) {
            $query = $db->prepare("SELECT user_id from login_tokens WHERE token=:token");
            $query->execute(array(':token'=> sha1($_COOKIE['SNID'])));

            return $query->fetchAll()[0]->user_id;            
         }

         return -1;
    }

    public static function get_username($db){
        if (isset($_COOKIE['SNID'])) {
            $query = $db->prepare("SELECT u.username FROM users as u
                                   JOIN login_tokens as t on u.id = t.user_id 
                                   WHERE t.token =:token");
            $query->execute(array(':token'=> sha1($_COOKIE['SNID'])));

            return $query->fetchAll()[0]->username;
         }

         return "";
    }

    public static function set_cookie($token) {
        setcookie("BID",$token, time() + 60 * 60 * 24 * 7, NULL, NULL, TRUE);
    }

    public static function is_email_registered($db, $email) {
        $query = $db->prepare("SELECT email from users WHERE email=:email");
        $query->execute(array(':email'=> $email));

        return isset($query->fetchAll()[0]->email);
    }

    public static function is_logged($db){
        if (isset($_COOKIE['SNID'])) {
          $query = $db->prepare("SELECT user_id from login_tokens WHERE token=:token");
          $query->execute(array(':token'=> sha1($_COOKIE['SNID'])));
          $result = $query->fetchAll();
          $userid = isset($result[0]->user_id) ? $result[0]->user_id : null;

           // check for second cookie, if not set generate new one 
           if($userid && !isset($_COOKIE['SNID_'])){
                // generate new token and insert in db
                $token = Security::generate_token();         
                
                $query_insert = $db->prepare("INSERT INTO login_tokens (token, user_id) VALUES(:token, :user_id)");
                $query_insert->execute(array(':token' => sha1($token), ':user_id' => $userid));
                
                // delete old one
                $query_delete = $db->prepare("DELETE FROM login_tokens WHERE token=:token");
                $query_delete->execute(array(':token'=> sha1($_COOKIE['SNID'])));

                // set new cookies
                setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                setcookie("SNID_", 1, time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);  
           }

           return isset($userid);
        }

        return false;
    }

    public static function logout($db) {
        if (isset($_COOKIE['SNID'])) {
            $query_delete = $db->prepare("DELETE FROM login_tokens WHERE token=:token");
            $query_delete->execute(array(":token" => sha1($_COOKIE["SNID"])));


            //delete cookie and  expire 
            unset($_COOKIE['SNID']);
            unset($_COOKIE['SNID_']);
            setcookie('SNID', null, time()-3600);
            setcookie('SNID_', null, time()-3600);
        }                
    }
}

