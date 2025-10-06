<?php

use Hanafalah\ModulePayment\Models\Payment\Channel;
use Hanafalah\ModulePayment\Models\Transaction\Deposit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use Hanafalah\MicroTenant\Concerns\Tenant\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.Deposit', Deposit::class));
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
                $channel = app(config('database.models.Channel',Channel::class));

                $table->ulid('id')->primary();
                $table->string('code', 50)->nullable();
                $table->string('name', 255)->nullable(false);
                $table->foreignIdFor($channel::class)->nullable()->index()->constrained()
                      ->cascadeOnUpdate()->restrictOnDelete();
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
