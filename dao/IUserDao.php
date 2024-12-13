<?php

namespace dao;

interface IUserDao
{
    public function selectUser($email);
    public function insertUser($email, $password);

    public function updateUserApi($tel ,$nom ,$cognom);

}
