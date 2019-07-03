<?php

use App\Models\System\Role;
use App\Models\System\User;

class UsersTableSeeder extends \Illuminate\Database\Seeder
{

    public function __construct()
    {
    }

    public function run()
    {
        $developer_email = "master@gmail.com";
        $developer = User::where('email', '=', $developer_email)->first();
        if (!$developer)
            $developer = User::updateOrCreate([
                "email" => $developer_email,
                "password" => bcrypt("123456"),
                'activation_token' => 'xxxxxxxx',
                'active' => true
            ]);
        if (!$developer->hasRole('master'))
            $developer->assignRole('master');
        if (!$developer->hasDirectPermission('ONE_ABOVE_ALL'))
            $developer->givePermissionTo('ONE_ABOVE_ALL');

        Role::all()->each(function (Role $role) {
            $role_name = $role->name;
            // @var User $user_created
            $user_created = User::where('email', '=', "$role_name.user@platform.com")->first();
            if (!$user_created)
                $user_created = User::updateOrCreate([
                    "email" => "$role_name.user@platform.com",
                    "password" => bcrypt("$role_name.pass"),
                    'activation_token' => 'xxxxxxxx',
                    'active' => true
                ]);
            if (!$user_created->hasRole($role_name))
                $user_created->assignRole($role_name);
            if (!$user_created->hasDirectPermission('ONE_ABOVE_ALL'))
                $user_created->givePermissionTo('ONE_ABOVE_ALL');
        });
    }
}
