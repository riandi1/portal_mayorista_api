<?php

namespace App\Http\Controllers;

use App\Models\System\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        parent::__construct(Permission::class);
    }

    public function hasPermissionTo($permission_name){
        check_permission($permission_name);
        return jsend_success([],200);
    }
}
