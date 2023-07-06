<?php

use App\Models\Token;


if (! function_exists('generateToken')) {
    /**
     * Generate a unique token for a user.
     *
     * @return string
     */
    function generateToken()
    {
        do {
            $token = mt_rand(11111111, 99999999);
        } while (Token::where('token', $token)->exists());

        return (string) $token;
    }
}
