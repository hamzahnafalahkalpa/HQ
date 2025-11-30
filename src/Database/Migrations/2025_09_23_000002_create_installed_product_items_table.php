<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Projects\Hq\Models\InstalledProductItem;
use Projects\Hq\Models\ProductItem;
use Projects\Hq\Models\Submission;

return new class extends Migration
{
    use Hanafalah\MicroTenant\Concerns\Tenant\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.InstalledProductItem', InstalledProductItem::class));
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
                $product_item  = app(config('database.models.ProductItem', ProductItem::class));
                $submission  = app(config('database.models.Submission', Submission::class));

                $table->ulid('id')->primary();
                $table->string('name', 255)->nullable(false);
                $table->string('reference_type', 50)->nullable(false);
                $table->string('reference_id', 50)->nullable(false);
                $table->foreignIdFor($product_item::class)->index()->constrained()->restrictOnDelete()->cascadeOnUpdate();
                $table->foreignIdFor($submission::class)->index()->constrained()->restrictOnDelete()->cascadeOnUpdate();
                $table->unsignedBigInteger('price')->nullable(true)->default(0);
                $table->unsignedBigInteger('actual_price')->nullable(true)->default(0);
                $table->unsignedBigInteger('discount')->nullable(true)->default(0);
                $table->unsignedBigInteger('total_price')->nullable(true)->default(0);
                $table->unsignedInteger('qty')->nullable(true)->default(1);
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
