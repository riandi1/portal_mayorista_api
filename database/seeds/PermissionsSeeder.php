<?php

use App\Models\Model;
use App\Models\System\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    private $sufixs = ['index', 'show', 'store', 'update', 'destroy'];
    private $permissions = [
        'specials' => [
            'one_above_all' => 'Maximum cosmic power',
            'allow_login' => 'Allow login to system',
            'system_over_scope' => 'Include not related information'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissions as $module => $permission)
            foreach ($permission as $name => $description)
                Permission::updateOrCreate([
                    'name' => strtoupper($name),
                    'description' => $description,
                    'module' => $module,
                    'guard_name' => 'web'
                ]);

        $this->modelPermissions(Permission::class, ['destroy', 'update', 'store'], [
            'ASSIGN' => trans("messages.acl.assign")
        ]);
        $this->modelPermissions(\App\Models\System\User::class, [], [
            'MESSAGE' => trans("messages.user.permissions.message")
        ]);
        $this->modelPermissions(\App\Models\System\Parameter::class);
        $this->modelPermissions(\App\Models\System\Tag::class);
        $this->modelPermissions(\App\Models\System\TagAssignment::class);
        $this->modelPermissions(\App\Models\System\Binnacle::class, [], [
            'OVER_SCOPE' => 'Show all binnacle'
        ]);
        $this->modelPermissions(\App\Models\System\Comment::class);
        $this->modelPermissions(\App\Models\System\Email::class);
        $this->modelPermissions(\App\Models\Store\Product::class);
        $this->modelPermissions(\App\Models\Store\ProductMovement::class, [], [
            'INPUT' => trans("messages.inventory.permissions.input"),
            'OUTPUT' => trans("messages.inventory.permissions.output"),
            'MASS' => trans("messages.inventory.permissions.mass")
        ]);
        $this->modelPermissions(\App\Models\Cms\Page::class);
        $this->modelPermissions(\App\Models\Cms\PageVar::class);
        $this->modelPermissions(\App\Models\System\CustomField::class);
        $this->modelPermissions(\App\Models\System\CustomData::class);
        $this->modelPermissions(\App\Models\Store\Category::class);
    }


    /**
     * Run the database seeds.
     *
     * @param Model $model
     * @param array $except
     * @param array $extras
     * @return void
     */
    protected function modelPermissions($model, $except = [], $extras = [])
    {
        $prefix = $model::prefix();
        $module = strtolower($prefix) . ' module';
        foreach (array_diff($this->sufixs, $except) as $permission_name) {
            $name = strtoupper($prefix . '_' . $permission_name);
            $permission = Permission::query()->where('name', '=', $name)->first();
            $data = [
                'name' => $name,
                'module' => $module,
                'description' => trans('messages.models.permissions.' . $permission_name, [
                    'model' => $prefix
                ]),
                'guard_name' => 'web'
            ];
            if (!is_null($permission)) {
                $permission->fill($data);
                $permission->save();
            } else Permission::updateOrCreate($data);
        }

        foreach ($extras as $name => $description) {
            $_name = strtoupper($prefix . '_' . $name);
            $permission = Permission::query()->where('name', '=', $_name)->first();
            $data = [
                'name' => strtoupper($prefix . '_' . $name),
                'module' => $module,
                'description' => $description,
                'guard_name' => 'web'
            ];
            if (!!$permission) {
                $permission->fill($data);
                $permission->save();
            } else Permission::updateOrCreate($data);
        }
    }
}
