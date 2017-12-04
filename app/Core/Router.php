<?php

namespace App\Core;

use App\Core\Exceptions\{
    MethodNotAllowedException, RouteNotFoundException
};

/**
 * Class Router
 * Router class handles adding routes reads from routes file and routing to the right component when hitting a link
 * @package App\Core
 */
class Router
{
    protected $path;

    protected $action;

    protected $routes = [];

    protected $methods = [];

    /**
     * @param $uri string repressing uri that will be called in each case
     * @param $handler string represents a callable the handler for this uri , method
     * @param $method string represents the verb which is used for this route
     *
     * adds routes and handlers to list for  calling the uri later in the application
     */
    public function addRoute($uri, $handler, $method)
    {
        $slashFound = preg_match('/^\//', $uri);
        if (!$slashFound) {
            $uri = '/' . $uri;
        }
        // TODO:this should not remove the {} but reads what's between them then save it as a parameter for the request to handled with it
        // Parameters are now handled using $_GET,$_POST server vars
        $parametersFound = preg_match('/{(.*?)}/', $uri);
        if ($parametersFound) {
            $uri = substr(preg_replace('/{(.*?)}/', '', $uri), 0, -1);
        }
        $this->routes[$uri][$method]['handler'] = $handler;
    }

    /**
     * @param $action string represents the action
     * sets action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @param $value array , number
     * pass input to secure function in order to get rid of unwanted input
     * @return array of values parameters after applying the secure process
     */
    //TODO: if sent bit code this should make sure that the code is not harmful (image uploads) , needs more search
    /**
     * gets request parameters array
     */
    public function getParameters()
    {
        return $this->routes[$this->path][$this->action]['parameters'];
    }

    /**
     * @param $path string represents the route path
     * sets path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * gets the handler when hitting the url
     */
    public function getHandler()
    {
        if (!isset($this->routes[$this->path])) {
            throw new RouteNotFoundException;
        }
        if (!isset($this->routes[$this->path][$this->action])) {
            throw new MethodNotAllowedException;
        }
        $parameters = $this->extractParameters($this->action);
        $this->routes[$this->path][$this->action]['parameters'] = $parameters;
        return $this->routes[$this->path][$this->action]['handler'];
    }

    /**
     * @param $method string represents the verb which is used for this route
     * extracts the parameters from the request passing them to secure function in order to get rid of unwanted input
     * @return array of parameters
     */
    private function extractParameters($method)
    {
        switch (strtolower($method)) {
            case 'get':
            case 'delete':
                $parameters = $this->secureParameters($_GET);
                break;
            case 'post':
                $parameters = $this->secureParameters($_POST);
                break;
            case 'put':
            case 'patch':
                $parameters = json_decode(file_get_contents('php://input'), true);
                break;
            default:
                $parameters = [];
        }
        return $parameters;
    }


    private function secureParameters($value)
    {
        if (!is_numeric($value)) {
            if (is_array($value)) {
                foreach ($value AS $key => $v) {
                    if (is_array($v)) $value[$key] = $this->secureParameters($v);
                    else {
                        if (get_magic_quotes_gpc())
                            $value[$key] = htmlspecialchars(trim($v));
                        else
                            $value[$key] = htmlspecialchars(addslashes(trim($v)));
                    }
                }
            } else {
                if (get_magic_quotes_gpc())
                    $value = htmlspecialchars(trim($value));
                else
                    $value = htmlspecialchars(addslashes(trim($value)));
            }
        }
        return $value;
    }


}