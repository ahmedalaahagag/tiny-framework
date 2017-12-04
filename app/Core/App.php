<?php

namespace App\Core;

use App\Core\{
    Exceptions\InvalidRouteArgumentException
};
use Symfony\{
    Component\Console\Application
};

/**
 * Class App
 * The applications lives in this class
 * @package App\Core
 */
class App
{

    public function __construct()
    {
        // Service Container Holds Route and Response Objects for each request
        $this->container = new Container([
            // TODO: request class should replace router
            'router' => function () {
                return new Router;
            },
            'response' => function () {
                return new Response;
            },
        ]);
    }

    /**
     * handles get method routes reads from routes file
     * @param $uri
     * @param $handler
     */
    public function get($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, 'GET');
    }

    /**
     * handles delete method routes reads from routes file
     * @param $uri
     * @param $handler
     */
    public function delete($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, 'DELETE');
    }

    /**
     * handles post method routes reads from routes file
     * @param $uri
     * @param $handler
     */
    public function post($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, 'POST');
    }

    /**
     * handles put method routes reads from routes file
     * @param $uri
     * @param $handler
     */
    public function put($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, 'PUT');
    }

    /**
     * handles patch method routes reads from routes file
     * @param $uri
     * @param $handler
     */
    public function patch($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, 'PATCH');
    }

    /**
     * application run function gets the appropriate function to run then returns the response
     */
    public function run()
    {
        $commands = new Application();

        $commands->add(new CreateCrudCommand());

        $router = $this->container->router;

        $router->setPath(rtrim(strtok($_SERVER['PATH_INFO'], '?'), '/') ?? '/');

        $router->setAction($_SERVER['REQUEST_METHOD'] ?? '');

        $handler = $router->getHandler();

        $response = $this->route($handler);

        echo $this->respond($response);
    }

    /**
     * responds to incoming uris with json format
     * @param $response
     * @return mixed
     */
    // TODO : Resolve Response According to Client (API-WEB VIEW)
    /**
     * instantiate new class of the handler checking if it's callable
     * @param $handler
     * @return mixed
     * @throws InvalidRouteArgumentException
     */
    public function route($handler)
    {
        if (is_array($handler)) {
            $class = "\\App\\Controllers\\{$handler[0]}";
            $handler[0] = new $class($this);
        }

        if (!is_callable($handler)) {
            throw new InvalidRouteArgumentException;
        }

        return call_user_func($handler, $this);
    }


    public function respond($response)
    {
        if (!$response instanceof Response) {
            $this->app()->response()->json($response);
        }

        return $response->getBody();
    }

    /**
     * bind services to app
     * @param $key
     * @param callable $callable
     */
    public function bind($key, Callable $callable)
    {
        $this->container[$key] = $callable;
    }

    /**
     * gets response service instance from container
     * @return mixed|null
     */
    public function response()
    {
        return $this->container->response;
    }

    /**
     * gets other services from the contanier without the need to write a seperate funtion for each service
     * @return mixed|null
     */
    public function __get($property)
    {
        return $this->container[$property];
    }

}
