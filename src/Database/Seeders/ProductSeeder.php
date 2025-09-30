<?php

namespace Projects\Hq\Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Hanafalah\LaravelPermission\Facades\LaravelPermission;
use Hanafalah\LaravelSupport\Concerns\Support\HasRequest;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use HasRequest;

    protected $__products = [
        ['flag' => 'LITE', 'name' => 'Wellmed Lite'],
        ['flag' => 'PLUS', 'name' => 'Wellmed Plus'],
        ['flag' => 'E', 'name' => 'Wellmed E']
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->__products as $product) {
            app(config('app.contracts.Product'))->prepareStoreProduct($this->requestDTO(config('app.contracts.ProductData'),[
                'name' => $product['name'],
                'flag' => $product['flag']
            ]));
        }
    }
}
