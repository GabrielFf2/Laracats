<?php

namespace Core\Middleware;

use Core\Authenticator;

class AuthenticatedToken
{
    public function handle()
    {
        $headers = getallheaders();
        $tokenHeader = $headers['Authorization'] ?? null;

        if (!$tokenHeader) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Token not found']);
            exit();
        }

        $user =  (new Authenticator)->tokenAuthenticated($tokenHeader);

        if (!$user) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Unauthorized']);
            exit();
        }
        return $user;
    }
}