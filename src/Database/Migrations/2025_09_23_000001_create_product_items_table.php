<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\LaravelFeature\Models\MasterFeature;
use Hanafalah\LaravelFeature\Models\Version;
use Projects\Hq\Models\MasterProductItem;
use Projects\Hq\Models\Product;
use Projects\Hq\Models\ProductItem;

return new class extends Migration
{
    use Hanafalah\MicroTenant\Concerns\Tenant\NowYouSeeMe;

    

    public function __construct()
    {
        $this->__table = app(config('database.models.ProductItem', ProductItem::class));
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        $this->isNotTableExists(function() use ($table_name){
            Schema::create($table_name, function (Blueprint $table) {
                $product  = app(config('database.models.Product', Product::class));
                $master_product  = app(config('database.models.MasterProductItem', MasterProductItem::class));

                $table->ulid('id')->primary();
                $table->string('name', 255)->nullable(false);
                $table->string('flag', 100)->nullable(false);
                $table->foreignIdFor($product::class,'product_id')->nullable()
                    ->index()->constrained()->restrictOnDelete()->cascadeOnUpdate();
                $table->foreignIdFor($master_product::class,'master_product_item_id')->nullable(false)
                    ->index()->constrained()->restrictOnDelete()->cascadeOnUpdate();
                $table->unsignedBigInteger('price')->nullable(true)->default(0);
                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->__table->getTable());
    }
};
