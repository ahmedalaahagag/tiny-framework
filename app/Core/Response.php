<?php

namespace App\Core;

/**
 * Class Response
 * handles response for the application
 * @package App\Core
 */
class Response
{
    protected $body;

    protected $statusCode = 200;

    protected $headers = [];

    /**
     * returns json response
     * @param array $data
     * @return $this
     */
    public function json(array $data)
    {
        $this->setBody(json_encode($data));

        $this->setHeader('Content-Type', 'application/json');

        return $this;
    }

    /**
     * sets response header using key value
     * @param $name
     * @param $value
     * @return $this
     */
    public function setHeader($name, $value)
    {
        $this->headers[] = [$name, $value];

        return $this;
    }

    /**
     * gets response body
     * @return mixed
     */
    public function getBody()
    {
        $this->withHeaders();

        return $this->body;
    }

    /**
     * sets response body
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * construct header to be sent with the response
     */
    public function withHeaders()
    {
        header(sprintf(
            'HTTP/%s %s %s',
            '1.1',
            $this->statusCode,
            ''
        ));

        foreach ($this->getHeaders() as $header) {
            header($header[0] . ': ' . $header[1]);
        }
    }

    /**
     * gets headers
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * get status code
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * sets status code
     * @param $statusCode integer for now only 200 OK
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

}
