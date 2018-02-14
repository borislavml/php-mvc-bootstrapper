<?php

class Home extends Controller {

    public function index() {
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'sidebar.php';
        require Config::get('PATH_VIEWS') . 'home/index.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }

    public function notfound() {
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS') . 'home/notfound.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }

    public function error() {
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS') . 'home/error.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }
}