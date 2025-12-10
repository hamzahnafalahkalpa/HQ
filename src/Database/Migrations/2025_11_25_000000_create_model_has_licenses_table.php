<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\ModuleLicense\Models\{
    ModelHasLicense
};

return new class extends Migration
{
    use Hanafalah\MicroTenant\Concerns\Tenant\NowYouSeeMe;

    

    public function __construct()
    {
        $this->__table = app(config('database.models.ModelHasLicense', ModelHasLicense::class));
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
                $license = app(config('database.models.License', \Hanafalah\ModuleLicense\Models\License::class));

                $table->ulid('id')->primary();
                $table->string('model_type');
                $table->string('model_id');
                $table->foreignIdFor($license::class)->index()
                    ->constrained()->onUpdate('cascade')->onDelete('cascade');
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
