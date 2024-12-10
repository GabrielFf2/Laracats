<?php

namespace dao;

interface IUserDao
{
    public function selectUser($email);
    public function insertUser($email, $password, $apiKey);

}
