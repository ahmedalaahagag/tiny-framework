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

//news Routes
$app->get('/news/{id}', ['newsController', 'read']);
$app->post('/news/create', ['newsController', 'create']);
$app->delete('/news/{id}', ['newsController', 'delete']);
$app->patch('/news', ['newsController', 'update']);

//name Routes
$app->get('/name/{id}', ['nameController', 'read']);
$app->post('/name/create', ['nameController', 'create']);
$app->delete('/name/{id}', ['nameController', 'delete']);
$app->patch('/name', ['nameController', 'update']);

//ahmed Routes
$app->get('/ahmed/{id}', ['ahmedController', 'read']);
$app->post('/ahmed/create', ['ahmedController', 'create']);
$app->delete('/ahmed/{id}', ['ahmedController', 'delete']);
$app->patch('/ahmed', ['ahmedController', 'update']);

//ahmed Routes
$app->get('/ahmed/{id}', ['ahmedController', 'read']);
$app->post('/ahmed/create', ['ahmedController', 'create']);
$app->delete('/ahmed/{id}', ['ahmedController', 'delete']);
$app->patch('/ahmed', ['ahmedController', 'update']);

//ahmed Routes
$app->get('/ahmed/{id}', ['ahmedController', 'read']);
$app->post('/ahmed/create', ['ahmedController', 'create']);
$app->delete('/ahmed/{id}', ['ahmedController', 'delete']);
$app->patch('/ahmed', ['ahmedController', 'update']);

//alll Routes
$app->get('/alll/{id}', ['alllController', 'read']);
$app->post('/alll/create', ['alllController', 'create']);
$app->delete('/alll/{id}', ['alllController', 'delete']);
$app->patch('/alll', ['alllController', 'update']);

//alllsadas Routes
$app->get('/alllsadas/{id}', ['alllsadasController', 'read']);
$app->post('/alllsadas/create', ['alllsadasController', 'create']);
$app->delete('/alllsadas/{id}', ['alllsadasController', 'delete']);
$app->patch('/alllsadas', ['alllsadasController', 'update']);
