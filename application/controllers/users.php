<?php


class Users extends Controller {

    /** TO DO - AUTHORIZATION */
    public function list() {
        // handle POST request for searching
        if (isset($_POST['list'])) {
        }

        $users_model = $this->load_model('users', 'ListModel');
        $users = $users_model->get_users();

        // handle GET request        
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        // always set 'active_menu_option' after header.php otherwise it's overriden there 
        $active_menu_option = "users";

        require Config::get('PATH_VIEWS_TEMPLATES') . 'sidebar.php';
        require Config::get('PATH_VIEWS') . 'users/list.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';

     
    }
}