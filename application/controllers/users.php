<?php


class Users extends Controller {

    public function list() {
        // handle POST request for searching
        if (isset($_POST['list'])) {
        }

        $users_model = $this->load_model('users', 'ListModel');
        $users = $users_model->get_users();

        // handle GET request
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'sidebar.php';
        require Config::get('PATH_VIEWS') . 'users/list.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }
}