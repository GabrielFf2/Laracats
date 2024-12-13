<?php

namespace Core;

use dao\DAOFactory;
use Http\Forms\LoginForm;

class Authenticator
{

    public function attempt($email, $password)
    {
        $user = App::resolve(Database::class)
            ->query('select * from users where email = :email', [
                'email' => $email
            ])->find();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $tocken = bin2hex(random_bytes(32));
                $this->insertTocken($tocken, $user['id']);
                $this->login([
                    'email' => $email,
                    'id' => $user['id'],
                    'tocken' => $tocken
                ]);

                return true;
            }
        }

        return false;
    }

    public function insertTocken($token, $idUser)
    {
        return App::resolve(Database::class)
            ->query('INSERT INTO tokens (token , idUser , expire) VALUES (:token , :idUser , :expire)', [
                'token' => $token,
                'idUser' => $idUser,
                'expire' => date('Y-m-d H:i:s', strtotime('+2 hour'))
            ]);
    }

    public function deleteTockens($idUser)
    {

        return App::resolve(Database::class)
            ->query('DELETE FROM tokens WHERE idUser = :idUser', [
                'idUser' => $idUser
            ]);

    }

    public function tokenAuthenticated($token)
    {
        $UseDao = new DAOFactory();
        $tokenSelect = $UseDao->getUserDAO()->selectUserByToken($token);
        if ($tokenSelect) {
            return [
                'id' => $tokenSelect['id'],
                'email' => $tokenSelect['email'],
                'token' => $tokenSelect['apiKey']
            ];
        }
        return null;
    }


    public function login($user)
    {
        Session::put('user', $user);
        session_regenerate_id(true);
    }

    public function logout()
    {
        //$this->deleteTocken($_SESSION['user']['id']);
        Session::destroy();
    }
    public function update($email ,$tel , $nom , $cognom){

        $user = App::resolve(Database::class)
            ->query('select * from users where email = :email', [
                'email' => $email
            ])->find();

        if ($user) {
            $this->update($tel , $nom , $cognom , $email);
            return true;
        }
        return false;
    }
}