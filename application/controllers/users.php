<?php


class Users extends Controller {

    /** TO DO - AUTHORIZATION */
    public function list() {
        // redirect unauthorized users
        $user_id = Security::get_current_userid($this->db);
        $user_is_admin = $user_id !== -1 && Security::user_is_in_role($this->db, $user_id, Config::get('ROLE_ADMIN'));
        if (!$user_is_admin) {
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
        $user_id = Security::get_current_userid($this->db);
        $user_is_admin = $user_id !== -1 && Security::user_is_in_role($this->db, $user_id, Config::get('ROLE_ADMIN'));
        if (!$user_is_admin) {
            header('location: ' . Config::get('URL') . 'home/forbidden');
        }
                
        $users_model = $this->load_model('users', 'UserModel');
        $user = $users_model->get_user($id);

        if (!$user) {
            header('location: ' . Config::get('URL') . 'home/notfound');
        }

        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        // always set 'active_menu_option' after header.php otherwise it's overriden there 
        $active_menu_option = "users";

        require Config::get('PATH_VIEWS_TEMPLATES') . 'sidebar.php';
        require Config::get('PATH_VIEWS') . 'users/user.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';     
    }
    
    public function edit_user(){
        // redirect unauthorized users
        $user_id = Security::get_current_userid($this->db);
        $user_is_admin = $user_id !== -1 && Security::user_is_in_role($this->db, $user_id, Config::get('ROLE_ADMIN'));
        if ($user_is_admin) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'No permission'));            
        }

        // $users_model = $this->load_model('users', 'EditModel');
        // $user = $users_model->edit_user();
    }
}