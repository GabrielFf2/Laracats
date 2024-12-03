<?php

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

$router->get('/notes', 'NotesController@index')->only('auth');
$router->post('/notes', 'NotesController@store')->only('auth');
$router->get('/notes/create', 'NotesController@create')->only('auth');
$router->get('/notes/{id}', 'NotesController@show')->only('auth');
$router->patch('/notes/{id}', 'NotesController@update')->only('auth');
$router->delete('/notes/{id}', 'NotesController@destroy')->only('auth');
$router->get('/notes/{id}/edit', 'NotesController@edit')->only('auth');

$router->get('/register', 'RegistrationController@create')->only('guest');
$router->post('/register', 'RegistrationController@store')->only('guest');

$router->get('/login', 'SessionController@create')->only('guest');
$router->post('/session', 'SessionController@store')->only('guest');
$router->delete('/session', 'SessionController@destroy')->only('auth');