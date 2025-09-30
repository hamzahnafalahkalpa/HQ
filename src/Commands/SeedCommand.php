<?php

namespace Projects\Hq\Commands;

use Illuminate\Support\Facades\Artisan;

class SeedCommand extends EnvironmentCommand{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hq:seed {class? : Class name of the seeder}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command ini digunakan untuk seeding';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $class = $this->argument('class') ?? "DatabaseSeeder";
        Artisan::call('db:seed',[
            '--class' => "Projects\Hq\\Database\Seeders\\$class"
        ]);   
    }
}