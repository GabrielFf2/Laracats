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

    public function insertUser($email, $password)
    {
        return $this->connection->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
            'email' => $email,
            'password' => $password,
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

    public function insertUserApi($email, $password, $tel, $nom, $cognom)
    {
        return $this->connection->query('INSERT INTO users (email, password, tel, nom, cognom) VALUES (:email, :password, :tel, :nom, :cognom)', [
            'email' => $email,
            'password' => $password,
            'tel' => $tel,
            'nom' => $nom,
            'cognom' => $cognom
        ]);
    }

    public function updateUserApi($tel, $nom, $cognom)
    {
        return $this->connection->query('UPDATE users SET tel = :tel, nom = :nom, cognom = :cognom WHERE email = :email', [
            'tel' => $tel,
            'nom' => $nom,
            'cognom' => $cognom,
            'email' => $_SESSION['user']['email']
        ]);
    }
}