<?php

class Account extends Controller {

    public function login(){              
        // handle POST request
        if (isset($_POST['login'])) {
            $login_model = $this->load_model('account', 'LoginModel');
            $validation_message =  $login_model->login($_POST['email'], $_POST['password']);
        }
        
        // handle GET request
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS') . 'account/login.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }

    public function register() {        
        // handle post request
        if (isset($_POST['create-account'])) {
            $regiset_model = $this->load_model('account', 'RegisterModel');
            $validation_message = $regiset_model->register($_POST['email'], $_POST['password'], $_POST['confirm-password']);
        }
        
        // handle GET request
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS') . 'account/register.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }

    public function logout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Security::logout($this->db);        
        }

        header('location: ' . Config::get('URL') . 'home/index');
    }
}