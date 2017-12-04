<?php

namespace App\Controllers;

use App\Core\App;

/**
 * Class Controller
 * @package App\Controllers
 */
abstract class Controller
{
    protected $parameters;
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->parameters = $this->routes()->getParameters();

    }

    /**
     * warrper to get router
     * @return mixed|null
     */
    protected function routes()
    {
        return $this->app()->container->router;
    }

    /**
     * return the running instance of app
     * @return App
     */
    protected function app()
    {
        return $this->app;
    }

    /**
     * warrper to get database object (QueryBuilder)
     * @return mixed|null
     */
    protected function builder()
    {
        return clone $this->app()->database;
    }

    /**
     * magic function allows direct access to properties
     * @param $property
     * @return mixed object of the accessed service
     */
    protected function __get($property)
    {
        return $this->app()[$property];
    }
}
