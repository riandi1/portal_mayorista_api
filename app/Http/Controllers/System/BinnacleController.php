<?php

namespace App\Http\Controllers;

use App\Models\System\Binnacle;
use App\Models\System\Permission;
use Auth;

class BinnacleController extends Controller
{
    public function __construct()
    {
        parent::__construct(Binnacle::class);
    }

    protected function wheres_scope(): array
    {
        $permission = Permission::query()->where('name', 'BINNACLE_OVER_SCOPE')->first();
        if (!Auth::user()->hasPermissionTo($permission))
            return [
                ['column' => 'user_id', 'value' => Auth::id(), 'op' => '=', 'or' => true]
            ];
        return [];
    }
}
