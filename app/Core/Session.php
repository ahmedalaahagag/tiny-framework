<?php

namespace App\Core;

/**
 * Class Session
 * Session class handles Sessions
 * @package App\Core
 */
class Session
{
    /**
     * Session constructor.
     */
    function __construct()
    {
    }

    /**
     * session start
     * @return $this session object
     */
    public function start()
    {
        session_start();
        return $this;
    }

    /**
     * gets a session variable
     * @param $name session variable name
     * @return mixed session object or false
     */
    function get($name)
    {
        if (isset($_SESSION[$name]))
            return $_SESSION[$name];
        return false;
    }

    /**
     * replaces a session variable
     * @param $name session variable name
     * @param $value session value
     */
    function replace($name, $value)
    {
        $this->delete($name);
        $this->set($name, $value);
    }

    /**
     * yes you guess it ! deletes a session variable
     * @param $name session variable name
     * @return $this session object
     */
    function delete($name)
    {
        unset($_SESSION[$name]);
        return $this;
    }

    /**
     * Sets a session variable
     * @param $name session variable name
     * @param $value session variable value
     * @return $this session object
     */
    function set($name, $value)
    {
        $_SESSION[$name] = $value;
        return $this;
    }

    /**
     * Destroys the session
     * @return $this session object
     */
    function destroy()
    {
        $_SESSION = array();
        return $this;
    }
}