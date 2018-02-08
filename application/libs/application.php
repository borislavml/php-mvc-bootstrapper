<?php

class Application {
    
    private $controller = null;
    private $action = null;
    
    // we can't get parameters count dynamiclly 
    //so we'll stick with 2 and add more if needed
    private $param_1 = null;
    private $param_2 = null;

    // start application
    // analyze url rewrite - parse controller, methods, params and fallbacks
    public function __construct(){
        $this->split_url();
        // check if requested controller exists
        if (file_exists('./application/controllers/'. $this->controller. '.php')) {

            // if so, then load this file and create this controller
            require './application/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller();

            // check if method/action for the requested controller exists
            if (method_exists($this->controller, $this->action)) {
                // check if parameters exists and call method with arguemnts
                if (isset($this->param_2)) {
                    $this->controller->{$this->action}($this->param_1, $this->param_2);
                } elseif(isset($this->param_1)) {
                    $this->controller->{$this->action}($this->param_1);
                } else {
                 // if no parameters provided just call the method
                   $this->controller->{$this->action}();
                }            
            } else {
                // default/fallback to controller-> index() action
                $this->controller->index();
            }                    
        } else {
            // invalid url 
            require './application/controllers/home.php';
            $home = new Home();
            $home->index();
        }        
    }

    private function split_url(){
        if (isset($_GET['url'])) {            
            // split url
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url,FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // set url parts to accrordin properties
            $this->controller = (isset($url[0]) ? $url[0] : null);
            $this->action = (isset($url[1]) ? $url[1] : null);
            $this->param_1 = (isset($url[2]) ? $url[2] : null);
            $this->param_2 = (isset($url[3]) ? $url[3] : null);
        }
    }
}