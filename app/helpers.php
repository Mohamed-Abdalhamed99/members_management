<?php

use App\Models\Student;
use App\Models\Token;
use Carbon\Carbon;

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


if (! function_exists('generateStudentCode')) {

    /**
     * generate unique code for each student in tenant app
     *
     * @return string
     */
    function generateStudentCode() : string
    {
        $today = Carbon::today();
        $series = Student::where('created_at' , $today)->count();
        $code = $today->format('ymd').sprintf("%03d", ++$series);
        return $code;
    }
}


