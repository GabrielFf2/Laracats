<?php

namespace Http\controllers;

use Core\Validator;
use Core\Authenticator;
use dao\DAOFactory;

class RegistrationController
{

    public function __construct()
    {
    }

    public function create()
    {
        view('registration/create.view.php', [
            'errors' => \Core\Session::get('errors')
        ]);
    }

    public function store()
    {
        $UseDao = new DAOFactory();

        $email = $_POST['email'];
        $password = $_POST['password'];
        $apiKey = bin2hex(random_bytes(16)); // Generate a random API key

        $errors = [];
        if (!Validator::email($email)) {
            $errors['email'] = 'Please provide a valid email address.';
        }

        if (!Validator::string($password, 7, 255)) {
            $errors['password'] = 'Please provide a password of at least seven characters.';
        }

        if (! empty($errors)) {
            return view('registration/create.view.php', [
                'errors' => $errors
            ]);
        }

        $user = $UseDao->getUserDAO()->selectUser($email);

        if ($user) {
            header('location: /');
            exit();
        } else {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $UseDao->getUserDAO()->insertUser($email, $passwordHash, $apiKey);
            $user = $UseDao->getUserDAO()->selectUser($email);
            (new Authenticator)->login(['idUser' => $user['id'], 'email' => $email]);
            header('location: /');
            exit();
        }
    }
}