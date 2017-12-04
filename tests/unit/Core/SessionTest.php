<?php

namespace tests;

use App\Core\Session;

class SessionTest extends \PHPUnit\Framework\TestCase
{
    protected $session;

    public function setUp()
    {
        $this->session = new Session();
    }

    public function testSessionStartedWhenCreatingNewSessionObject()
    {
        $this->assertEquals(session_status(), 1);
    }

    public function testSetSessionValueSetsTheValue()
    {
        $this->session->set('name', 'john');
        $sessionData = $this->session->get('name');
        $this->assertEquals($sessionData, 'john');
    }

    public function testGetSessionValueGetsTheValue()
    {
        $this->session->set('name', 'john');
        $this->session->set('anotherName', 'doe');
        $sessionData = $this->session->get('anotherName');
        $this->assertEquals($sessionData, 'doe');
    }

    public function testReplaceSessionValueReplacesTheValue()
    {
        $this->session->set('name', 'john');
        $this->session->replace('name', 'doe');
        $sessionData = $this->session->get('name');
        $this->assertEquals($sessionData, 'doe');
    }

    public function testDeleteSessionValueDeletesTheValueAndReturnsFalse()
    {
        $this->session->set('name', 'john');
        $this->session->delete('name');
        $sessionData = $this->session->get('name');
        $this->assertEquals($sessionData, false);
    }

    public function testDestroySessionValueRemovesAllTheSessions()
    {
        $this->session->set('name', 'john');
        $this->session->destroy();
        $this->assertEmpty($_SESSION);
    }
}
