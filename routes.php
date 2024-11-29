<?php

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');


$router->get('/notes', 'NotesController@index')->only('auth');

$router->get('/note', 'NotesController@show')->only('auth');;
$router->delete('/note', 'NotesController@destroy')->only('auth');;
$router->get('/note/edit', 'NotesController@edit')->only('auth');;
$router->patch('/note', 'NotesController@update')->only('auth');;


$router->get('/notes/create', 'NotesController@create')->only('auth');;
$router->post('/notes', 'NotesController@store')->only('auth');;


$router->get('/register', 'RegistrationController@create')->only('guest');
$router->post('/register', 'RegistrationController@store')->only('guest');

$router->get('/login', 'SessionController@create')->only('guest');
$router->post('/session', 'SessionController@store')->only('guest');
$router->delete('/session', 'SessionController@destroy')->only('auth');

