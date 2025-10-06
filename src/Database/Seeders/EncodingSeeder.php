<?php

namespace Projects\Hq\Database\Seeders;

use Illuminate\Database\Seeder;

class EncodingSeeder extends Seeder{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $workspace  = app(config('database.models.Workspace'))->uuid('9e7ff0f6-7679-46c8-ac3e-71da818160Hq')->firstOrFail();        
        foreach (config('module-encoding.encodings') as $encoding) {
            $encoding = app(config('database.models.Encoding'))
                        ->firstOrCreate([
                            'flag' => $encoding['flag'],
                        ],[
                            'name' => $encoding['name']
                        ]);

            $workspace->modelHasEncoding()->firstOrCreate([
                'reference_id'   => $workspace->getKey(),
                'reference_type' => $workspace->getMorphClass(),
                'encoding_id'    => $encoding->getKey()
            ]);
        }
    }
}
