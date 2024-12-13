<?php

namespace Http\controllers;
use Core\Authenticator;
use dao\DAOFactory;
use dao\UserDao;
use Http\Forms\LoginForm;
use Core\Session;
class SessionController{

    public function __construct(){
    }

    public function create(){
        view('session/create.view.php', [
            'errors' => Session::get('errors')
        ]);
    }

    public function store(){
        $form = LoginForm::validate($attributes = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ]);

        $signedIn = (new Authenticator)->attempt(
            $attributes['email'], $attributes['password']
        );

        if (!$signedIn) {
            $form->error(
                'email', 'No matching account found for that email address and password.'
            )->throw();
        }



        redirect('/');
    }

    public function update ()
    {
        $form = LoginForm::validate($attributes = [
            'tel' => $_POST['tel'],
            'nom' => $_POST['nom'],
            'cognom' => $_POST['cognom'],
        ]);

        $signedIn = (new Authenticator)->attempt(
            $attributes['tel'], $attributes['nom'], $attributes['cognom']
        );

        if (!$signedIn) {
            $form->error(
                'email', 'No matching account found for that email address and password.'
            )->throw();
        }

        redirect('/');
    }

    public function destroy(){
        (new Authenticator)->logout();
        header('location: /');
        exit();
    }

}