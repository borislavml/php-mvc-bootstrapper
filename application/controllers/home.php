<?php

class Home extends Controller {

    public function index() {
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'sidebar.php';
        require Config::get('PATH_VIEWS') . 'home/index.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }

    public function notfound() {
        http_response_code(404);
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS') . 'home/notfound.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }

    public function error() {
        http_response_code(500);
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS') . 'home/error.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }

    public function forbidden(){
        http_response_code(403);
        require Config::get('PATH_VIEWS_TEMPLATES') . 'header.php';
        require Config::get('PATH_VIEWS') . 'home/forbidden.php';
        require Config::get('PATH_VIEWS_TEMPLATES') . 'footer.php';
    }
}