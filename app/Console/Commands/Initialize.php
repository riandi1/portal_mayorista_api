<?php

namespace App\Console\Commands;

use App\Models\System\Permission;
use App\Models\System\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class Initialize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initialize 
    {--only-permissions} 
    {--no-permissions}
    {--no-autoload}
    {--no-migrate}
    {--no-no-seed}
    {--no-client}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->alert("Store API is initializing");

        $only_permissions = $this->option('only-permissions');
        if (!$only_permissions) {
            if (!$this->hasArgument('--no-autoload'))
                $this->autoload();

            if (!$this->hasArgument('--no-migrate'))
                $this->migrate();

            if (!$this->hasArgument('--no-seed'))
                $this->seed();

            if (!$this->hasArgument('--no-client'))
                $this->createClient(env('APP_CLIENT_NAME'));

            if (!$this->hasArgument('--no-permissions'))
                $this->assignPermissions();
        } else
            $this->assignPermissions();

    }

    private function migrate()
    {
        $this->comment("EXECUTING MIGRATION:");
        $output = new BufferedOutput();
        Artisan::call("migrate:refresh", [], $output);
        $this->info($output->fetch());
        $this->comment("");
    }

    private function seed()
    {
        $this->comment("EXECUTING DATABASE SEED:");
        $output = new BufferedOutput();
        Artisan::call("db:seed", [], $output);
        $this->info($output->fetch());
        $this->comment("");
    }

    private function createClient($client_name)
    {
        $this->comment("CREATING PASSPORT PERSONAL CLIENT:");
        $output = new BufferedOutput();
        Artisan::call("passport:client", [
            "--personal" => true,
            "--name" => $client_name
        ], $output);
        $this->info($output->fetch());
        $this->comment("");
    }

    private function autoload()
    {
        $this->comment("EXECUTE DUMP-AUTOLOAD: ");
        exec('composer dump-autoload');
        $this->comment("");
    }

    private function assignPermissions()
    {
        $this->comment("ASSIGN PERMISSIONS: ");
        $roles = Role::all();
        $permissions = Permission::all();
        $roles->each(function ($role) use ($permissions) {
            $role->revokePermissionTo($permissions);
            $permissions->each(function ($permission) use ($role) {
                $permission_name = $permission->name;
                if ($permission_name === 'ONE_ABOVE_ALL')
                    return;
                $rules = AppValues::PERMISSIONS_MAP[$role->name];
                if ($rules) {
                    $gives = $rules['give'];
                    $excepts = $rules['except'];
                    $give = false;
                    foreach ($gives as $regx)
                        if (preg_match($regx, $permission_name)) {
                            $give = true;
                            break;
                        }
                    if (!$give) return;
                    foreach ($excepts as $regx)
                        if (preg_match($regx, $permission_name)) {
                            $give = false;
                            break;
                        }
                    if ($give && !$role->hasPermissionTo($permission->name))
                        $role->givePermissionTo($permission_name);

                }
            });
        });
        $this->info("Permissions assigned");
    }
}

Class AppValues
{
    const PERMISSIONS_MAP = [
        'master' => [
            'give' => ['/.*/'],
            'except' => ['/TICKET\_WORKER/']
        ],
        'admin' => [
            'give' => ['/.*/'],
            'except' => ['/TICKET\_WORKER/', '/PERMISSION\_.*/'],
        ],
        'coordinator' => [
            'give' => ['/.*/'],
            'except' => [
                '/TICKET\_WORKER/',
                '/PERMISSION\_.*/',
                '/ROLE\_.*/',
                '/SYSTEM\_OVER\_SCOPE/',
                '/PARAMETER\_.*/'
            ]
        ],
        'employee' => [
            'give' => ['/.*/'],
            'except' => [
                '/USER\_.*/',
                '/ROLE\_.*/',
                '/PERMISSION\_.*/',
                '/PARAMETER\_.*/',
                '/BOOKING\_.*/',
                '/TICKET\_CANCEL/',
                '/TICKET\_STORE/',
                '/TICKET\_DESTROY/',
                '/TICKET\_UPDATE/',
                '/PRODUCT\_MOVEMENT\_INDEX/',
                '/PRODUCT\_MOVEMENT\_SHOW/',
                '/PRODUCT\_MOVEMENT\_DESTROY/',
                '/PRODUCT\_MOVEMENT\_INPUT/',
                '/SYSTEM\_OVER\_SCOPE/'
            ]
        ],
        'owner' => [
            'give' => ['/ALLOW\_LOGIN/'],
            'except' => []
        ]
    ];
}
