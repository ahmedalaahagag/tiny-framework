<?php

namespace tests\unit\core;

use App\Core\Container;
use App\Core\Response;
use Mockery;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    protected $container;

    public function setUp()
    {
        $this->container = new Container([]);
        $this->container->offsetSet('response', function () {
            return new Response();
        });
    }

    public function testContainerGetsServiceObject()
    {
        $this->container = new Container(['response' => function () {
            return new Response();
        }]);
        $this->assertInstanceOf(Response::class, $this->container->offsetGet('response'));
    }

    public function testContainerSetsService()
    {
        $this->assertInstanceOf(Response::class, $this->container->offsetGet('response'));
    }

    public function testHasReturnsTrueOrFalse()
    {
        $this->assertTrue($this->container->has('response'));
        $this->assertFalse($this->container->has('router'));
    }

    public function testUnsetRemovesService()
    {
        $this->container->offsetUnset('response');
        $this->assertFalse($this->container->has('response'));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
