<?php

namespace Core;

use Core\Middleware\Middleware;
use Http\controllers\NotesController;
use Http\controllers\RegistrationController;
use Http\controllers\SessionController;


class Router
{
    protected $routes = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];
        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }

/*    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                Middleware::resolve($route['middleware']);


                if (strpos($route['controller'], '@')) {
                    list($controller, $method) = explode('@', $route['controller']);
                    $this->useController($controller, $method);
                } else {
                    return require base_path('Http/controllers/' . $route['controller']);
                }

            }
        }

        $this->abort();
    }

    function useController($controller, $method)
    {
        require base_path("Http/controllers/$controller.php");
        if ($controller === 'RegistrationController') {
            $RegistrationController = new RegistrationController;
            call_user_func([$RegistrationController, $method]);
        } else if ($controller === 'NotesController') {
            $NotesController = new NotesController;
            call_user_func([$NotesController, $method]);
        } else if ($controller === 'SessionController') {
            $SessionController = new SessionController;
            call_user_func([$SessionController, $method]);
        }

    }*/
    /**
     * @throws \Exception
     */
    public function route($uri, $method){
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route['uri']);
            if (preg_match('#^' . $pattern . '$#', $uri, $matches) && $route['method'] === strtoupper($method)) {
                $user = Middleware::resolve($route['middleware']);
                array_shift($matches);
                if (strpos($route['controller'], '@')) {
                    list($controller, $method) = explode('@', $route['controller']);
                    $this->useController($controller, $method, $matches, $user);
                } else {
                    return require base_path('Http/controllers/' . $route['controller']);
                }
            }
        }
        $this->abort();
    }
    function useController($controller, $method, $params = [], $user = null)
    {
        $controllerPath = base_path("Http/controllers/$controller.php");
        if (file_exists($controllerPath)) {
            require $controllerPath;
            $controllerClass = "Http\\controllers\\$controller";
            $controllerInstance = new $controllerClass;
            call_user_func_array([$controllerInstance, $method], [$params, $user, true]);
        } else {
            throw new \Exception("Controller file not found: $controllerPath");
        }
    }
    public function previousUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }
}




































