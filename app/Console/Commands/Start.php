<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class Start extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start project';

    /**
     * Host from start server.
     *
     * @var string
     */
    protected $host;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->host = env('APP_HOST');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $enviroment = $this->option('env');
        if(!isset($enviroment))
            $enviroment = App::environment();
        switch ($enviroment){
            case 'local': $this->startAsLocal(); break;
            case 'dev': $this->startAsDevelop(); break;
            case 'prod': $this->startAsProduction(); break;
            default: $this->error('"--env" is not correctly defined, Allowed: "local","dev","prod". ');
        }
    }

    private function startAsLocal(){
        $this->alert("Run app as Local");
        $this->comment("STATING SEVER: ".$this->host.":80");
        $error = Artisan::call("serve", [
            '--host' => $this->host,
            '--port' => 80
        ]);
        if($error) $this->error("Error on starting server");
    }

    private function startAsDevelop(){
        $this->alert("Run app as Development");
        $this->error("Function not implement");
    }

    private function startAsProduction(){
        $this->alert("Run app as Production");
        $this->error("Function not implement");
    }
}
