<?php

include_once('classes/db.php');

class Security {

    public static function generate_token() {
        $crypto_strong  = True;
        return bin2hex(openssl_random_pseudo_bytes(64, $crypto_strong));
    }

    public static function get_userid_byemail($email){
       return DB::query('SELECT id FROM users WHERE email=:email', array(':email'=> $email))[0]['id'];
    }

    public static function email_registered($email){
        return DB::query("SELECT email from users WHERE email=:email", array(':email'=> $email));
    }

    public static function get_userid(){
        if (isset($_COOKIE['SNID'])) {
            return  DB::query('SELECT user_id from login_tokens WHERE token=:token',array(':token'=> sha1($_COOKIE['SNID'])))[0]['user_id'];
         }
    }

    public static function get_username(){
        if (isset($_COOKIE['SNID'])) {
            $query = "SELECT u.username FROM users as u JOIN login_tokens as t on u.id = t.user_id where t.token =:token";
            $params = array(':token'=> sha1($_COOKIE['SNID']));

            return DB::query($query, $params)[0]['username'];
         }
    }

    public static function set_cookie($token) {
        setcookie("BID",$token, time() + 60 * 60 * 24 * 7, NULL, NULL, TRUE);
    }

    public static function is_logged(){

        if (isset($_COOKIE['SNID'])) {
           $userid =  DB::query('SELECT user_id from login_tokens WHERE token=:token',array(':token'=> sha1($_COOKIE['SNID'])))[0]['user_id'];
           
           // check for second cookie, if not set generate new one 
           if($userid && !isset($_COOKIE['SNID_'])){
                // generate new token and insert in db
                $token = Security::generate_token();                
                DB::query('INSERT INTO login_tokens (token, user_id) VALUES(:token, :user_id)', array(':token'=>sha1($token), ':user_id'=> $userid));
                // delete old one
                DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=> sha1($_COOKIE['SNID'])));

                // set new cookies
                setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                setcookie("SNID_", 1, time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);  
           }

           return true;
        }

        return false;
    }
}

?>