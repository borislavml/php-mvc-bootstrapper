<?php

class Account extends Controller {

    public function login(){              
        // handle POST request
        if (isset($_POST['login'])) {
            $login_model = $this->load_model('account', 'LoginModel');
            $validation_message =  $login_model->login($_POST['email'], $_POST['password']);
        }
        
        // handle GET request
        require './application/views/_templates/header.php';
        require 'application/views/account/login.php';
        require './application/views/_templates/footer.php';
    }

    public function register() {        
        // handle post request
        if (isset($_POST['create-account'])) {
            $regiset_model = $this->load_model('account', 'RegisterModel');
            $validation_message = $regiset_model->register($_POST['email'], $_POST['password'], $_POST['confirm-password']);
        }
        
        // handle GET request
        require './application/views/_templates/header.php';
        require 'application/views/account/register.php';
        require './application/views/_templates/footer.php';
    }

    public function logout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_COOKIE['SNID'])) {
                $query_delete = $this->db->prepare("DELETE FROM login_tokens WHERE token=:token");
                $query_delete->execute(array(":token" => sha1($_COOKIE["SNID"])));
    
    
                //delete cookie and  expire 
                unset($_COOKIE['SNID']);
                unset($_COOKIE['SNID_']);
                setcookie('SNID', "", time()-3600);
                setcookie('SNID_', "", time()-3600);
            }          
        }

        header('location: ' . URL . 'home/index');
    }
}