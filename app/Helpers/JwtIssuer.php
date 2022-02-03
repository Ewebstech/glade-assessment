<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
Trait JwtIssuer {

    public function JwtIssuer($user) {

        $payload = [
            'iss' => "app-jwt", // Issuer of the token
            'sub' => $user->email,
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 3600*60 // Expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');

    }


}
