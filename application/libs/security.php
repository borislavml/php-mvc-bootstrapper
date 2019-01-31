<?php

class Security {

    public static function generate_token() {
        $crypto_strong  = True;

        return bin2hex(openssl_random_pseudo_bytes(64, $crypto_strong));
    }

    public static function get_userid_byemail(PDO $db, string $email){
        $query = $db->prepare("SELECT id FROM users WHERE email=:email");
        $query->execute(array(":email" => $email));

        return  $query->fetchAll()[0]->id;
    }

    public static function get_current_userid(PDO $db): int {
        if (isset($_COOKIE['SNID'])) {
            $query = $db->prepare("SELECT user_id from login_tokens WHERE token=:token");
            $query->execute(array(':token'=> sha1($_COOKIE['SNID'])));

            $result = $query->fetchAll();
            return isset($result[0]->user_id) ? $result[0]->user_id  : -1;            
         }

         return -1;
    }

    public static function get_user(PDO $db, int $id){
            $query = $db->prepare("SELECT email, username, date_registered from users WHERE id=:id");
            $query->execute(array(':id'=> $id));
            $result = $query->fetchAll();

            return isset($result[0]) ? $result[0]: null;            
    }

    public static function get_current_username(PDO $db): string {
        if (isset($_COOKIE['SNID'])) {
            $query = $db->prepare("SELECT u.username FROM users as u
                                   JOIN login_tokens as t on u.id = t.user_id 
                                   WHERE t.token =:token");
            $query->execute(array(':token'=> sha1($_COOKIE['SNID'])));

            return $query->fetchAll()[0]->username;
         }

         return "";
    }

    public static function get_current_user_email(PDO $db): string {
        if (isset($_COOKIE['SNID'])) {
            $query = $db->prepare("SELECT u.email FROM users as u
                                   JOIN login_tokens as t on u.id = t.user_id 
                                   WHERE t.token =:token");
            $query->execute(array(':token'=> sha1($_COOKIE['SNID'])));

            return $query->fetchAll()[0]->email;
         }

         return "";
    }

    public static function set_cookie(string $token) {
        setcookie("BID",$token, time() + 60 * 60 * 24 * 7, NULL, NULL, TRUE);
    }

    public static function is_email_registered(PDO $db, string $email):bool {
        $query = $db->prepare("SELECT email from users WHERE email=:email");
        $query->execute(array(':email'=> $email));

        return isset($query->fetchAll()[0]->email);
    }

    public static function is_logged(PDO $db): bool {
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

    public static function login(PDO $db, string $email) {
        // generate token, insert hashed token in DB, set token in cookie
        $token = Security::generate_token($db);
        $user_id  = Security::get_userid_byemail($db, $email);
    
        $query_insert = $db->prepare("INSERT INTO login_tokens (token, user_id) VALUES(:token, :user_id)");
        $query_insert->execute(array(':token' => sha1($token), ':user_id' => $user_id));

        setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
        setcookie("SNID_", 1, time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);   
    }

    public static function logout(PDO $db) {
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

    public static function user_is_in_role(PDO $db, int $user_id, int $role_id): bool {
        $query = $db->prepare("SELECT user_id from users_in_roles WHERE user_id=:user_id AND role_id=:role_id");
        $query->execute(array(":user_id" => $user_id, ":role_id" => $role_id));

        $result = $query->fetchAll();

        return isset($result[0]->user_id);        
    }

    public static function user_has_permission(PDO $db, int $user_id, int $permission_id): bool {
        $query = $db->prepare("SELECT user_id from user_permissions WHERE user_id=:user_id AND permission_id=:permission_id");
        $query->execute(array(":user_id" => $user_id, ":permission_id" => $permission_id));

        $result = $query->fetchAll();
        
        return isset($result[0]->user_id);
    }

    public static function authorize(PDO $db, int $role): bool {
        $user_id = self::get_current_userid($db);
        
        return ($user_id !== -1) && self::user_is_in_role($db, $user_id, $role);
    } 
}

