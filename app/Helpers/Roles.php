<?php

namespace App\Helpers;

class Roles {

    Const
        DELETE_ACCOUNT = ['superadmin'],
        CREATE_ADMIN_ACCOUNT =  ['superadmin'],
        CREATE_EMPLOYEE_ACCOUNT = ['superadmin', 'admin', 'company'],
        CREATE_COMPANY_ACCOUNT = ['superadmin', 'admin'],
        VIEW_EMPLOYEES = ['superadmin', 'admin', 'company'];

}
