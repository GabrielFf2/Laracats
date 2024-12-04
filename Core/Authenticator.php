<?php

namespace Core;

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
                $this->insertTocken($tocken,$user['id']);
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

    public function insertTocken($token, $idUser){
        return App::resolve(Database::class)
            ->query('INSERT INTO tokens (token , idUser , expire) VALUES (:token , :idUser , :expire)', [
            'token' => $token,
            'idUser' => $idUser,
            'expire' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);
    }

    public function deleteTocken( $idUser){

        return App::resolve(Database::class)
            ->query('DELETE FROM tokens WHERE idUser = :idUser', [
                'idUser' => $idUser
            ]);

    }

    public function selectUserByTocken($tocken){
        return App::resolve(Database::class)
            ->query('SELECT * FROM tockens WHERE tocken = :tocken', [
                'tocken' => $tocken
            ])->find();
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'email' => $user['email'],
            'id' => $user['id']
        ];

        session_regenerate_id(true);
    }

    public function logout()
    {
        $this->deleteTocken($_SESSION['user']['id']);
        Session::destroy();
    }
}