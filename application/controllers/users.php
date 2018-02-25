<?php

class Users extends Controller {

    public function list() {
        // redirect unauthorized users
        if (!Security::authorize($this->db, Config::get('ROLE_ADMIN'))) {
            header('location: ' . Config::get('URL') . 'home/forbidden');
        }

        $users_model = $this->load_model('users', 'ListModel');
        $users = $users_model->get_users();
  
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        // always set 'active_menu_option' after header.php otherwise it's overriden there 
        $active_menu_option = "users";

        require Config::get('PATH_VIEWS_TEMPLATES') . 'sidebar.php';
        require Config::get('PATH_VIEWS') . 'users/list.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';     
    }

    public function user($id) {
        // redirect unauthorized users
        if (!Security::authorize($this->db, Config::get('ROLE_ADMIN'))) {
            header('location: ' . Config::get('URL') . 'home/forbidden');
        }
                
        $user_model = $this->load_model('users', 'UserModel');
        $user = $user_model->get_user($id);

        if (!$user) {
            header('location: ' . Config::get('URL') . 'home/notfound');
        }

        $user_roles = $user_model->get_roles($id);
        $user_roles_ids = array_map('reset', $user_roles);

        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        // always set 'active_menu_option' after header.php otherwise it's overriden there 
        $active_menu_option = "users";

        require Config::get('PATH_VIEWS_TEMPLATES') . 'sidebar.php';
        require Config::get('PATH_VIEWS') . 'users/user.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';     
    }
    
    public function edit_user_profile(){
        header('Content-Type: application/json');
        // redirect unauthorized users
        if (!Security::authorize($this->db, Config::get('ROLE_ADMIN'))) {
            echo json_encode(array('error' => 'No permission'));            
            return;
        }

        $query = $this->db->prepare("UPDATE users SET username=:username, email=:email WHERE id=:id");
        $update =  $query->execute(array(':username' => $_POST['username'], ':email' => $_POST['email'], ':id' => $_POST['user_id']));
                     
        if ($update)  {
            echo json_encode(array('message' => 'User profile sucessfully updated'));      
        } else {
            echo json_encode(array('error' => 'Error trying to update user profile!')); 
        }
    }

    public function edit_user_roles(){
        header('Content-Type: application/json');
        // redirect unauthorized users
        if (!Security::authorize($this->db, Config::get('ROLE_ADMIN'))) {
            echo json_encode(array('error' => 'No permission'));            
            return;
        }
        
        $user_model = $this->load_model('users', 'UserModel');
        $user_edit_roles_success = $user_model->edit_roles($_POST['user_id'],  $_POST['admin_role']);

        if ($user_edit_roles_success)  {
            echo json_encode(array('message' => 'User roles sucessfully updated'));      
        } else {
            echo json_encode(array('error' => 'Error trying to update user roles!')); 
        }
    }

    public function change_user_password(){
        header('Content-Type: application/json');
        // redirect unauthorized users
        if (!Security::authorize($this->db, Config::get('ROLE_ADMIN'))) {
            echo json_encode(array('error' => 'No permission'));            
            return;
        }
               
        $user_model = $this->load_model('users', 'UserModel');
        $change_password_error = $user_model->change_password($_POST['user_id'], $_POST['new-password'], $_POST['confirm-password']);
    
        if (empty($change_password_error))  {
            echo json_encode(array('message' => 'User password sucessfully changed'));      
        } else {
            echo json_encode(array('error' =>  $change_password_error)); 
        }
    }
}