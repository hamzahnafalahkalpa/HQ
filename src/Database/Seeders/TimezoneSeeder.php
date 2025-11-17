<?php

namespace Projects\Hq\Database\Seeders;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Illuminate\Database\Seeder;

class TimezoneSeeder extends Seeder{
    use HasRequestData;

    public function run(): void
    {
        $datas = [
            [
                'name' => 'Asia/Jakarta',
                'label' => 'WIB'
            ],
            [
                'name' => 'Asia/Makassar',
                'label' => 'WITA'
            ],
            [
                'name' => 'Asia/Jayapura',
                'label' => 'WIT'
            ]
        ];
        foreach ($datas as $data) {
            app(config('app.contracts.Timezone'))->prepareStoreTimezone(
                $this->requestDTO(config('app.contracts.TimezoneData'),$data)
            );
        }
    }
}