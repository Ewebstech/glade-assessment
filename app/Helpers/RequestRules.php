<?php

namespace App\Helpers;


class RequestRules
{
    private static $rules = [
        'LOGIN' => [
            'email' => 'required|email',
            'password' => 'required|string'
        ],
        'CREATE_ADMIN_ACCOUNT' => [
            'firstname' => 'required|string',
            'lastname' => 'nullable',
            'email' => 'required|email',
            'role' => 'required|string',
            'password' => 'required|string'
        ],
        'CREATE_COMPANY_ACCOUNT' => [
            'firstname' => 'required|string',
            'lastname' => 'nullable',
            'email' => 'required|email',
            'role' => 'required|string',
            'password' => 'required|string',
            'logo' => 'required|string',
            'website' => 'required|string'
        ],
         'CREATE_EMPLOYEE_ACCOUNT' => [
            'firstname' => 'required|string',
            'lastname' => 'nullable',
            'email' => 'required|email',
            'role' => 'required|string',
            'password' => 'required|string',
            'phone' => 'required|string',
            'companyId' => 'required'
        ],
        'DELETE_ACCOUNT' => [
            'email' => 'required'
        ]

    ];


    public static function getRule($name)
    {
        return self::$rules[$name];
    }

}
