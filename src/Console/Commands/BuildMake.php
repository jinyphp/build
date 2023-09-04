<?php

namespace Jiny\Build\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;


class BuildMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'static build';

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
     * @return int
     */
    public function handle()
    {
        $this->info("Static Build");

        /*
        $email = $this->argument('email');

        $isAdmin = $this->option('enable') ? 1:0;
        if($this->option('disable')) {
            $this->disableAdmin($email);
        } else {
            $this->enableAdmin($email);
        }



        if($isAdmin) {
            $this->info('Success : '. $email." is Admin user");
        } else {
            $this->info('Success : '. $email." is normal user");
        }
        */

        return 0;
    }




}
