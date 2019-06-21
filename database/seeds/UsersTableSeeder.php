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
                "name" => "Master",
                "email" => $developer_email,
                "password" => bcrypt("123456"),
                'document_number' => '111111',
                'document_type_id' => 1,
                'country_id' => 45,
                'state_id' => 15,
                'city_id' => 641,
            ]);
        if (!$developer->hasRole('master'))
            $developer->assignRole('master');
        if (!$developer->hasDirectPermission('ONE_ABOVE_ALL'))
            $developer->givePermissionTo('ONE_ABOVE_ALL');

        Role::all()->each(function (Role $role) {
            $role_name = $role->name;
            /** @var User $user_created */
            $user_created = User::where('email', '=', "$role_name.user@platform.com")->first();
            if (!$user_created)
                $user_created = User::updateOrCreate([
                    "name" => "User $role_name",
                    "email" => "$role_name.user@platform.com",
                    "password" => bcrypt("$role_name.pass"),
                    'document_number' => '111111'.$role_name,
                    'document_type_id' => 1,
                    'country_id' => 45,
                    'state_id' => 15,
                    'city_id' => 641,
                ]);
            if (!$user_created->hasRole($role_name))
                $user_created->assignRole($role_name);
            if (!$user_created->hasDirectPermission('ONE_ABOVE_ALL'))
                $user_created->givePermissionTo('ONE_ABOVE_ALL');
        });
    }
}
