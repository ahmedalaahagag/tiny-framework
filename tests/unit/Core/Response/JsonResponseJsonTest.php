<?php

namespace App\Tests\Response;

use App\Core\Response;
use PHPUnit\Framework\TestCase;

class JsonResponseJsonTest extends TestCase
{
    protected $response;

    protected $arrayData;

    protected $jsonData;

    public function setUp()
    {
        $this->response = new Response();

        $this->arrayData = ['foo' => 'bar'];

        $this->jsonData = '{"foo":"bar"}';

        parent::setUp();
    }

    public function testSetAndRetrieveJsonableData()
    {
        $response = $this->response->json($this->arrayData);
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('foo', $data);
    }

    public function testSetAndRetrieveStatusCode()
    {
        $response = $this->response->json($this->arrayData);
        $response->setStatusCode(404);
        $this->assertSame(404, $response->getStatusCode());
    }

    public function testSetAndRetrieveResponseHeaders()
    {
        $response = $this->response->json($this->arrayData);
        $response->setHeader('foo', 'bar');
        $this->assertArrayHasKey('foo', $response->getHeaders());
    }

    public function testSetAndRetrieveResponseBody()
    {
        $response = $this->response->setBody($this->jsonData);
        $body = $response->getBody();
        $this->assertArrayHasKey('foo', json_decode($body, true));
    }

}