<?php

namespace App\Helpers;

use Firebase\JWT\JWT;

Trait JwtIssuer {

    public function JwtIssuer($user) {
       
        $payload = [
            'iss' => "advertapp-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 3600*60 // Expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }
}