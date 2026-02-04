<?php

namespace Projects\Hq\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class ApiAccessSeeder extends Seeder{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "[DEBUG] Booting ".class_basename($this)."\n";
        $workspace  = app(config('database.models.Workspace'))->uuid('9e7ff0f6-7679-46c8-ac3e-71da818160Hq')->firstOrFail();        
        $api_access = app(config('database.models.ApiAccess'))
                    ->where('reference_type',$workspace->getMorphClass())
                    ->where('reference_id',(string) $workspace->getKey())
                    ->first();
        if (!isset($api_access)){
            $exitCode = Artisan::call('helper:generate', [
                '--app-code'       => 3,
                '--algorithm'      => 'HS256',
                '--reference-id'   => (string) $workspace->getKey(),
                '--reference-type' => $workspace->getMorphClass(),
                '--secret'         => 'YXYlGIbJ65VGjQnETWXoOiCvqpXg7PHq'
            ]);
    
            if ($exitCode !== 0) {
                $this->command->error('Failed generating API access.');
                return;
            }
        }
        $this->command->info('API access generated.');
    }
}