<?php

namespace App\Core\Database;

use PDO;
use PDOException;

/**
 * Class Connection
 * @package App\Core\Database
 */
class Connection
{
    /**
     * connection function returns PDO driver object to start using the DB with it's interfaces
     * @param $container
     * @return PDO
     */
    public function connect($container)
    {
        $config = $container['config']['database'];

        try {
            return new PDO(
                $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }
}