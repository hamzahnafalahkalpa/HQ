<?php

use Hanafalah\MicroTenant\Concerns\Tenant\NowYouSeeMe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Projects\Hq\Models\ModuleWorkspace\Workspace;
use Projects\Hq\Models\Product;
use Projects\Hq\Models\Submission;

return new class extends Migration
{
    use NowYouSeeMe;
    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.Workspace', Workspace::class));
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        $this->isNotColumnExists('product_id',function() use ($table_name){
            Schema::table($table_name, function (Blueprint $table) {
                $product = app(config('database.models.Product',Product::class));

                $table->foreignIdFor($product::class,'product_id')->nullable()
                      ->after('owner_id')
                      ->index()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            });
        });

        $this->isNotColumnExists('submission_id',function() use ($table_name){
            Schema::table($table_name, function (Blueprint $table) {
                $submission = app(config('database.models.Submission',Submission::class));

                $table->foreignIdFor($submission::class,'submission_id')->nullable()
                      ->after('owner_id')
                      ->index()->constrained()->cascadeOnUpdate()->restrictOnDelete();
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
