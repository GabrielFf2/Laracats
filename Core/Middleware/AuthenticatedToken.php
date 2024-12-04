<?php

namespace Core\Middleware;

class AuthenticatedToken
{
    public function handle(){

        $headers = getallheaders();

        $token = $headers['Authorization'] ?? null;

        dd($token);

    }

}


