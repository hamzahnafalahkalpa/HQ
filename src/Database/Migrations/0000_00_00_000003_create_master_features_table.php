<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\LaravelFeature\Models\MasterFeature;

return new class extends Migration
{
    use Hanafalah\MicroTenant\Concerns\Tenant\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.MasterFeature', MasterFeature::class));
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
                $table->ulid('id')->primary();
                $table->string('uuid', 255)->unique()->nullable(false);
                $table->string('name', 255)->nullable(false);
                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        });

        $this->isNotColumnExists('parent_id',function() use ($table_name){
            Schema::table($table_name, function (Blueprint $table) use ($table_name) {
                $table->foreignIdFor($this->__table::class, 'parent_id')
                    ->after('id')->nullable()->index()->constrained($table_name)
                    ->cascadeOnUpdate()->restrictOnDelete();
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
