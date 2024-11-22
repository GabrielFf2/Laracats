<?php

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');


$router->get('/notes', 'NotesController@index')->only('auth');

$router->get('/note', 'NotesController@show');
$router->delete('/note', 'NotesController@destroy');
$router->get('/note/edit', 'NotesController@edit');
$router->patch('/note', 'NotesController@update');


$router->get('/notes/create', 'NotesController@create');
$router->post('/notes', 'NotesController@store');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/session', 'session/store.php')->only('guest');
$router->delete('/session', 'session/destroy.php')->only('auth');
