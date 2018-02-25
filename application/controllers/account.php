<?php

class Account extends Controller {

    public function login(){  
        //redirect already logged in users              
        if (Security::is_logged($this->db)) {
            header('location: ' . Config::get('URL') . 'home/index');
        }
        
        // handle POST request
        if (isset($_POST['login'])) {
            $login_model = $this->load_model('account', 'LoginModel');
            $validation_message =  $login_model->login($_POST['email'], $_POST['password']);
            $email = $_POST['email'];
        }
        
        // handle GET request
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS') . 'account/login.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }

    public function register() {     
        //redirect already logged in users              
        if (Security::is_logged($this->db)) {
            header('location: ' . Config::get('URL') . 'home/index');
        }

        // handle post request
        if (isset($_POST['create-account'])) {
            $regiset_model = $this->load_model('account', 'RegisterModel');
            $validation_message = $regiset_model->register($_POST['email'], $_POST['password'], $_POST['confirm-password']);
            $email = $_POST['email'];
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

    public function profile() {     
        //redirect already logged in users              
        if (!Security::is_logged($this->db)) {
            header('location: ' . Config::get('URL') . 'home/index');
        }

        $profile_model = $this->load_model('account', 'ProfileModel');
        $profile = $profile_model->get_profile();
        
        // handle GET request
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS') . 'account/profile.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }

    public function edit_profile(){
        // redirect unauthorized users
        $user_id = Security::get_current_userid($this->db);
        if ($user_id !==  $_POST['user_id']) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'No permission'));            

            return;
        }

        $query = $this->db->prepare("UPDATE users SET username=:username, email=:email WHERE id=:id");
        $update =  $query->execute(array(':username' => $_POST['username'], ':email' => $_POST['email'], ':id' => $_POST['user_id']));
                     
        if ($update)  {
            header('Content-Type: application/json');
            echo json_encode(array('message' => 'Account profile sucessfully updated'));      
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'Error trying to update Account profile!')); 
        }
    }

    public function change_password(){
        // redirect unauthorized users
        $user_id = Security::get_current_userid($this->db);
        if ($user_id !==  $_POST['user_id']) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'No permission'));      

            return;
        }
               
        $profile_model = $this->load_model('account', 'ProfileModel');
        $change_password_error = $profile_model->change_password($_POST['user_id'], $_POST['current-password'], $_POST['new-password'], $_POST['confirm-password']);

        if (empty($change_password_error))  {
            header('Content-Type: application/json');
            echo json_encode(array('message' => 'Password sucessfully changed'));      
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('error' =>  $change_password_error)); 
        }
    }
}