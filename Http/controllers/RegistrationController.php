<?php

namespace Http\controllers;
use Core\App;
use Core\Database;
use Core\Validator;
use Core\Authenticator;
class RegistrationController{

    public function __construct(){}

    public function create()
    {
        view('registration/create.view.php', [
            'errors' => \Core\Session::get('errors')
        ]);
    }

    public function store()
    {
        $form = \Http\Forms\RegistrationForm::validate($attributes = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ]);

        $user = (new \Core\Authenticator)->register($attributes);

        if (!$user) {
            $form->error(
                'email', 'An account with that email address already exists.'
            )->throw();
        }

        redirect('/');
    }

}