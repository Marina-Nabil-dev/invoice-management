<?php

namespace App\Enums;

enum EmployeeRolesEnum: string
{
    use EnumHelper;

    case Admin = 'admin';
    case Employee = 'employee';
}
