<?php

use Hanafalah\MicroTenant\Concerns\Tenant\NowYouSeeMe;
use Hanafalah\ModuleEncoding\Models\Encoding\Encoding;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use NowYouSeeMe;

    /**
     * Run the migrations.
     */
    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.Encoding', Encoding::class));
    }
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        $this->isNotTableExists(function() use ($table_name){
            Schema::create($table_name, function (Blueprint $table) {
                $table->ulid('id')->primary();
                $table->string('name',100);
                $table->string('flag', 45)->nullable();
                $table->timestamps();
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
