<?php
/**
 * Bootstrap the application binding config file and database connection , query builder
 */
$app->bind('config', function () {
    return require __DIR__ . '/../config.php';
});

$app->bind('databaseConnection', [new App\Core\Database\Connection, 'connect']);

$app->bind('database', function ($app) {
    return new App\Core\Database\QueryBuilder($app->databaseConnection);
});

$app->bind('session', [new \App\Core\Session(), 'start']);

$app->bind('file', [new \App\Core\File(), 'start']);
