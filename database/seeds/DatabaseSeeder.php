<?php

use App\Models\System\Permission;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');
        //$this->call(CountrySeeder::class);
       // $this->call(StateSeeder::class);
        $this->call(PlanTableSeeder::class);
        $this->call(UtilTableSeeder::class);
        $this->call(ParametersSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->permissionsToMaster();
        $this->permissionsToSeller();
    }

    public function permissionsToMaster()
    {
        $master_role = SpatieRole::query()->where('name', 'master')->first();
        if (!!$master_role) {
            Permission::all()->each(function ($permission) use ($master_role) {
                $permission_name = strtoupper($permission->name);
                if ($permission_name !== 'ONE_ABOVE_ALL' && $permission_name != 'TICKET_WORKER') {
                    if (!$master_role->hasPermissionTo($permission->name))
                        $master_role->givePermissionTo($permission->name);
                }
            });
        }
    }



    public function permissionsToSeller()
    {
        $seller_role = SpatieRole::query()->where('name', 'seller')->first();
        if (!!$seller_role) {
            Permission::all()->each(function ($permission) use ($seller_role) {
                $permission_name = strtoupper($permission->name);
                if ($permission_name !== 'ONE_ABOVE_ALL' && $permission_name != 'TICKET_WORKER') {
                    $valid = strpos($permission_name, 'CATEGORY');
                    if ($valid === false) {
                        if (!$seller_role->hasPermissionTo($permission->name))
                            $seller_role->givePermissionTo($permission->name);
                    }
                }
            });
        }
    }

}
