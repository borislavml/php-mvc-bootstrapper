<?php

class UserManager {
 
    public static function create_user(PDO $db, string $email, string $password) : int {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);   

        $query_insert =  $db->prepare("INSERT INTO users (username, email, password, date_registered) VALUES(:username, :email, :password, UTC_TIMESTAMP())");
        $query_insert->execute(array(':username' => $email , ':email' => $email, ':password' => $hashed_password));
                
        return $db->lastInsertId(); 
    }

    public static function add_user_to_role(PDO $db, int $user_id, int $role_id): bool {
        $query_insert =  $db->prepare("INSERT INTO users_in_roles (user_id, role_id) VALUES(:user_id, :role_id)");
        
        return $query_insert->execute(array(':user_id' => $user_id, ':role_id' => $role_id));        
    }

    public static function remove_user_from_role(PDO $db, int $user_id, int $role_id): bool {
        $query_delete =  $db->prepare("DELETE FROM users_in_roles WHERE user_id=:user_id and role_id=:role_id");
        
        return $query_delete->execute(array(':user_id' => $user_id, ':role_id' => $role_id));
    }

    public static function add_user_permission(PDO $db, int $user_id, int $permission_id): bool {
        $query_insert =  $db->prepare("INSERT INTO user_permissions (user_id, permission_id) VALUES(:user_id, :permission_id)");
        
        return $query_insert->execute(array(':user_id' => $user_id, ':permission_id' => $permission_id));       
    }

    public static function remove_user_permission(PDO $db, int $user_id, int $permission_id): bool {
        $query_delete =  $db->prepare("DELETE FROM user_permissions WHERE user_id=:user_id and permission_id=:permission_id");
        
        return $query_delete->execute(array(':user_id' => $user_id, ':permission_id' => $permission_id));
    }
     
    public static function set_password(PDO $db, int $user_id, string $password): bool {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);   

        $query_update = $db->prepare("UPDATE users SET  password=:password WHERE id=:id");
        
        return $query_update->execute(array(':password' => $hashed_password , ':id' => $user_id));        
    }

    public static function verify_password(PDO $db, int $user_id, string $password): bool {
        $query = $db->prepare("SELECT password FROM users WHERE id=:id");
        $query->execute(array(':id' => $user_id));
        $db_password = $query->fetchAll()[0]->password;

        return password_verify($password, $db_password);
    }
}