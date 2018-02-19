<?php

class Application {
    
    private $controller = null;
    private $action = null;
    private $parameters = null;

    // start application
    // analyze url rewrite - parse controller, methods, params and fallbacks
    public function __construct(){
        $this->split_url();

        $this->set_default_controller_and_action();

        // check if requested controller exists
        if (file_exists(Config::get('PATH_CONTROLLERS') . $this->controller. '.php')) {

            // if so, then load this file and create this controller
            require Config::get('PATH_CONTROLLERS') . $this->controller . '.php';            
            $this->controller = new $this->controller();

            // check if method/action for the requested controller exists
            if (method_exists($this->controller, $this->action)) {
                if (!empty($this->parameters)) {
                    // call the method and pass arguments to it
                    call_user_func_array(array($this->controller, $this->action), $this->parameters);
                } else {
                    // if no parameters are given, just call the method without parameters
                    $this->controller->{$this->action}();
                }       
            } else {
                // invalid url -> redirect to notfound or fallback to index action
                // check if home controller hasn't been required already as default              
                require  Config::get('PATH_CONTROLLERS') . 'home.php';  
                $home = new Home();
                $home->notfound();              
            }                    
        } else {
            // invalid url -> redirect to notfound
            require  Config::get('PATH_CONTROLLERS') . 'home.php';
            $home = new Home();
            $home->notfound();
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
            
            // remove controller and action from the split URL
            unset($url[0], $url[1]);

             // rebase array keys and store the URL parameters
             $this->parameters = array_values($url);
        }
    }

     /**
     * Checks if controller and action names are given. If not, default values are put into the properties.
     */
    private function set_default_controller_and_action() {
        if (!$this->controller) {
            $this->controller = Config::get('DEFAULT_CONTROLLER');
        }

        if (!$this->action || (strlen($this->action) == 0)) {
            $this->action = Config::get('DEFAULT_ACTION');
        }

    }
}