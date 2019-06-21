<?php

use App\Models\System\Role;

class RolesSeeder extends \Illuminate\Database\Seeder
{
    private $roles = [
        'master' => ['User master', 0],
        'admin' => ['Administrator', 1],
        'seller' => ['Seller', 2]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [];
        foreach ($this->roles as $name => [$display_name, $lvl])
            $roles[$name] = Role::updateOrCreate([
                'name' => $name,
                'display_name' => $display_name,
                'level' => $lvl,
                'guard_name' => 'web'
            ]);
    }
}
