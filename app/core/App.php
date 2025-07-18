<?php

class App {

    protected $controller = 'Login'; // default controller
    protected $method = 'index';     // default method
    protected $special_url = ['apply'];
    protected $params = [];

    public function __construct() {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
            $this->controller = 'Home';
        }

        $url = $this->parseUrl();

        if (isset($url[1])) {
            $controllerName = strtolower($url[1]); // file name (lowercase)
            $className = ucfirst($controllerName); // class name (capitalized)

            if (file_exists('app/controllers/' . $controllerName . '.php')) {
                require_once 'app/controllers/' . $controllerName . '.php';
                $this->controller = new $className;

                if (in_array($controllerName, $this->special_url)) {
                    $this->method = 'index';
                }

                unset($url[1]);
            } else {
                // fallback if controller doesn't exist
                require_once 'app/controllers/login.php';
                $this->controller = new Login;
            }
        } else {
            // no URL provided
            $file = 'app/controllers/' . strtolower($this->controller) . '.php';
            require_once $file;
            $this->controller = new $this->controller;
        }

        // method routing
        if (isset($url[2])) {
            if (method_exists($this->controller, $url[2])) {
                $this->method = $url[2];
                $_SESSION['method'] = $this->method;
                unset($url[2]);
            }
        }

        // remaining URL parts = parameters
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        $u = $_SERVER['REQUEST_URI'];
        $url = explode('/', filter_var(rtrim($u, '/'), FILTER_SANITIZE_URL));
        unset($url[0]); // remove empty index
        return $url;
    }
}
