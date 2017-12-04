<?php

namespace App\Core;

// Inspired by slim,lumen service container
// http://dev-notes.eu/2016/06/arrayaccess-php-interface/
// TODO:Container should be global it's now bound to the App class
use ArrayAccess;

/**
 * Class Container
 * Responsible for creating Service Container for the application and retrieve service
 * @package App\Core
 */
class Container implements ArrayAccess
{
    protected $items = [];
    protected $cache = [];

    /**
     * Container constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $key => $item) {
            $this->offsetSet($key, $item);
        }
    }

    /**
     * key value storage of the services on the application
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }


    /**
     * remove a service using it's offset
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->has($offset)) {
            unset($this->items[$offset]);
        }
    }

    /**
     * wrapper around offsetExists
     * @param mixed $offset
     * @return true|false
     */
    public function has($offset)
    {
        return $this->offsetExists($offset);
    }

    /**
     * indicates if service exists on container or not
     * @param mixed $offset
     * @return true|false
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * wrapper around offsetGet
     * @param $property
     * @return mixed|null
     */
    public function __get($property)
    {
        return $this->offsetGet($property);
    }

    /**
     * gets a service using it's offset
     * @param mixed $offset
     * @return mixed|null
     */
    //TODO : a solution needed to the call back mandatory usage of call_user_func
    public function offsetGet($offset)
    {
        if (!$this->has($offset)) {
            return null;
        }
        if (isset($this->cache[$offset])) {
            return $this->cache[$offset];
        }

        $item = call_user_func($this->items[$offset], $this);

        $this->cache[$offset] = $item;

        return $item;
    }
}
