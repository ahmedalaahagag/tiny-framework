<?php

return [

    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'fearless',
        'username' => 'root',
        'password' => 'root',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],
    'env' => [
        'development'
    ],
    'rootPath' => function () {
        return $_SERVER['DOCUMENT_ROOT'];
    }
];
