<?php

namespace dao;

use Core\Database;

class UserDao implements IUserDao
{
    private Database $connection;

    public function __construct(Database $connection)
    {
        $this->connection = $connection;
    }

    public function selectUser($email)
    {
        return $this->connection->query('SELECT * FROM users WHERE email = :email', [
            'email' => $email
        ])->find();
    }

    public function insertUser($email, $password, $apiKey)
    {
        return $this->connection->query('INSERT INTO users (email, password, apiKey) VALUES (:email, :password, :apiKey)', [
            'email' => $email,
            'password' => $password,
            'apiKey' => $apiKey
        ]);
    }

    public function selectUserByToken($token)
    {
        $sql = "Select * from users where apiKey = :token";
        return $this->connection->query($sql, [
            'token' => $token
        ])->find();
    }

    public function insertUserToken($idUser, $token)
    {
        return $this->connection->query('INSERT INTO tokens (idUser, token, expired) VALUES (:idUser, :token, :expired)', [
            'idUser' => $idUser,
            'token' => $token,
            'expired' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);
    }

    public function deleteUserToken($idUser)
    {
        return $this->connection->query('DELETE FROM tokens WHERE idUser = :idUser', [
            'idUser' => $idUser
        ]);
    }
}