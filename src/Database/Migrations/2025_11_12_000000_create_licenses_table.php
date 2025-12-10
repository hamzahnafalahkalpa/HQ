<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\ModuleLicense\Models\{
    License
};

return new class extends Migration
{
    use Hanafalah\MicroTenant\Concerns\Tenant\NowYouSeeMe;

    

    public function __construct()
    {
        $this->__table = app(config('database.models.License', License::class));
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
                $table->string('license_key', 255)->nullable(false);
                $table->string('reference_type', 50)->nullable(false);
                $table->string('reference_id', 26)->nullable(false);
                $table->timestamp('expired_at')->nullable();
                $table->timestamp('last_paid')->nullable();
                $table->timestamp('billing_generated_at')->nullable();
                $table->timestamp('due_date')->nullable();
                $table->string('status', 255)->nullable(false);
                $table->string('recurring_type', 255)->nullable(false);
                $table->string('flag', 100)->nullable(false);
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
