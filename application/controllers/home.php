<?php



class Home extends Controller {

    public function index() {
        require './application/views/_templates/header.php';
        require './application/views/_templates/sidebar.php';
        require 'application/views/home/index.php';
        require './application/views/_templates/footer.php';
    }

    public function not_foud() {
        require 'application/views/_templates/header.php';
        require 'application/views/home/not_found.php';
        require 'application/views/_templates/footer.php';
    }

    public function error() {
        require 'application/views/_templates/header.php';
        require 'application/views/home/error.php';
        require 'application/views/_templates/footer.php';
    }
}