<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\MicroTenant\Concerns\Tenant\NowYouSeeMe;
use Projects\Hq\Models\HqPermission;
use Projects\Hq\Models\HqRole;
use Projects\Hq\Models\HqRoleHasPermission;

return new class extends Migration
{
    use NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.HqRoleHasPermission', HqRoleHasPermission::class));
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        $this->isNotTableExists(function() use ($table_name){
            Schema::create($table_name, function (Blueprint $table) {
                $permission = app(config('database.models.HqPermission', HqPermission::class));
                $role       = app(config('database.models.HqRole', HqRole::class));

                $table->id();
                $table->foreignIdFor($permission::class)
                    ->nullable(false)
                    ->index()->constrained()->cascadeOnDelete()
                    ->cascadeOnUpdate();

                $table->foreignIdFor($role::class)
                    ->nullable(false)
                    ->index()->constrained()->cascadeOnDelete()
                    ->cascadeOnUpdate();
                $table->timestamps();

                $table->index([$role->getForeignKey(), $permission->getForeignKey()], 'role_permission');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->__table->getTableName());
    }
};
