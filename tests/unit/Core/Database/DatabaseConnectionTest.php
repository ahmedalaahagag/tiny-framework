<?php

namespace App\Tests\Database;

use App\Core\Database\Connection;
use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    protected $connection;

    protected $config;

    public function setUp()
    {
        $this->connection = new Connection();

        parent::setUp();
    }


    public function testIfDriverIsntSetExceptionIsThrown()
    {
        $mysqlConfig = [
            'database' => [
                'driver' => 'foo',
                'host' => '127.0.0.1',
                'database' => 'fearless',
                'username' => 'root',
                'password' => '',
                'options' => [],
            ]
        ];

        $this->expectExceptionMessageRegExp('%could not find driver%');
        $this->connection->connect($this->config = ['config' => $mysqlConfig]);
    }

    public function testIfDriverIsntSupportedExceptionIsThrown()
    {
        $mysqlConfig = [
            'database' => [
                'driver' => 'foo',
                'host' => '127.0.0.1',
                'database' => 'fearless',
                'username' => 'root',
                'password' => '',
                'options' => [],
            ]
        ];

        $this->assertEquals('could not find driver', $this->connection->connect($this->config = ['config' => $mysqlConfig]));
    }

    public function testMysqlConnectionCouldBeCreated()
    {
        $mysqlConfig = [
            'database' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'database' => 'fearless',
                'username' => 'root',
                'password' => 'root',
                'options' => [
                    'port' => '3306',
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                    'strict' => true,
                    'engine' => null,
                ],
            ]
        ];

        $this->assertInstanceOf('PDO', $this->connection->connect($this->config = ['config' => $mysqlConfig]));
    }

    public function testPostgresConnectionCouldBeCreated()
    {
        $psqlConfig = [
            'database' => [
                'driver' => 'pgsql',
                'host' => '127.0.0.1',
                'database' => 'fearless',
                'username' => 'postgres',
                'password' => 'root',
                'options' => [
                    'port' => '5432',
                    'charset' => 'utf8',
                    'prefix' => '',
                    'schema' => 'public',
                    'sslmode' => 'prefer',
                ]
            ]
        ];

        $this->assertInstanceOf('PDO', $this->connection->connect($this->config = ['config' => $psqlConfig]));
    }

    public function testSQLiteConnectionCouldBeCreated()
    {
        $sqlLiteConfig = [
            'database' => [
                'driver' => 'sqlite',
                'host' => null,
                'database' => 'database.sqlite',
                'username' => 'root',
                'password' => '',
                'options' => [
                    'prefix' => '',
                ]
            ]
        ];

        $this->assertInstanceOf('PDO', $this->connection->connect($this->config = ['config' => $sqlLiteConfig]));
    }
}
