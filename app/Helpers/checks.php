<?php

use App\Models\System\User;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;

if (!function_exists("eval_permission")) {

    /**
     * @param $permission_name
     * @return bool
     */
    function eval_permission($permission_name)
    {
        $permission_name = strtoupper($permission_name);
        $permission = Permission::query()->where('name', $permission_name)->first();
        $permission_cosmic = Permission::query()->where('name', 'ONE_ABOVE_ALL')->first();
        $hasPermission = $permission ? Auth::user()->hasPermissionTo($permission) : null;
        $hasCosmicPower = $permission_cosmic ? Auth::user()->hasPermissionTo($permission_cosmic) : null;
        return $hasPermission || $hasCosmicPower;
    }
}

if (!function_exists("check_permission")) {
    /**
     * @param $permission_name
     */
    function check_permission($permission_name, $and = false)
    {
        $result = false;
        if (is_array($permission_name)) {
            foreach ($permission_name as $name) {
                $name = strtoupper($name);
                if (eval_permission($name))
                    $results = true;
                else if ($and)
                    $results = false;
            }
        } else if (is_string($permission_name)) {
            $permission_name = strtoupper($permission_name);
            $results = eval_permission($permission_name);
        }
        if (!$results)
            throw UnauthorizedException::forPermissions([$permission_name]);

    }
}

if (!function_exists("check_role")) {
    /**
     * @param $role_name
     */
    function check_role($role_name)
    {
        $role_name = strtoupper($role_name);
        if (!Auth::user()->hasRole($role_name))
            throw UnauthorizedException::forRoles([$role_name]);

    }
}

if (!function_exists("check_required_lvl")) {
    /**
     * @param $lvl
     * @param bool $boolean
     */
    function check_required_lvl($lvl, $boolean = false)
    {
        $user_lvl = get_user_lvl(Auth::user());
        try {
//            if ($user_lvl === $lvl)
//                throw new UnauthorizedException(403, trans("messages.acl.errors.eq_level"));
            if ($user_lvl > $lvl)
                throw new UnauthorizedException(403, trans("messages.acl.errors.level", [
                    'lvl' => $user_lvl,
                    'req' => $lvl
                ]));
        } catch (UnauthorizedException $e) {
            if (!$boolean)
                throw $e;
            else
                return false;
        }
        if ($boolean)
            return true;
    }
}

if (!function_exists("get_user_lvl")) {
    /**
     * @param User $user
     * @return int|mixed
     */
    function get_user_lvl(User $user)
    {
        $roles = $user->roles;
        if (count($roles) > 0)
            $user_lvl = $roles->min('level');
        if (!isset($user_lvl))
            $user_lvl = PHP_INT_MAX;
        return $user_lvl;
    }
}


