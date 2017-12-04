<?php
// {id} is only presenting a parameter it will trimed while adding the route instead will depend on $_GET
//TODO : validate parameters required , optional

// User Routes
$app->get('/user/{id}', ['UsersController', 'read']);
$app->post('/user/login', ['UsersController', 'login']);
$app->post('/user/create', ['UsersController', 'create']);
$app->delete('/user/{id}', ['UsersController', 'delete']);
$app->patch('/user', ['UsersController', 'update']);
$app->get('/user/character', ['UsersController', 'character']);
