<?php

namespace App\Helpers;


class RequestRules
{
    private static $rules = [
        'LOGIN' => [
            'email' => 'required|email',
            'password' => 'required|string'
        ],
        'UPDATE_PROFILE' => [
            //validation rules
            'firstname' => 'nullable',
            'lastname' => 'nullable',
            'email' => 'email|required',
            'phonenumber' => 'required',
            'avatar' => 'nullable',
            'gender' => 'required',
            'role' => 'required',
            'password' => 'nullable'
        ],

    ];


    public static function getRule($name)
    {
        return self::$rules[$name];
    }

}
