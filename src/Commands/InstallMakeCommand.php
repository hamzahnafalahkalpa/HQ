<?php

namespace Projects\Hq\Commands;
use Illuminate\Support\Facades\App;

class InstallMakeCommand extends EnvironmentCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hq:install';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used for initial installation of this module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $provider = 'Projects\Hq\HqServiceProvider';

        $this->comment('Installing Module...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag'      => 'config'
        ]);
        $this->info('✔️  Created config/hq.php');

        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag'      => 'migrations'
        ]);
        $this->info('✔️  Created migrations');

        $this->call('optimize:clear');
        $direct_access = config('micro-tenant.direct_provider_access');

        config(['micro-tenant.direct_provider_access' => false]);
        $this->call('migrate', [
            '--force' => true,   // menambahkan flag force
        ]);

        $this->call('db:seed', [
            '--force' => true,   // menambahkan flag force
        ]);
        config(['micro-tenant.direct_provider_access' => $direct_access]);
        $this->callSilent('hq:seed');

        $this->comment('projects/hq installed successfully.');
    }
}
