<?php

namespace Projects\Hq\Controllers\API;

use App\Http\Controllers\ApiController as ControllersApiController;
use Illuminate\Support\Facades\Artisan;
use Projects\Hq\Concerns\HasUser;

abstract class ApiController extends ControllersApiController
{
    use HasUser;

    public function __construct(){
        config(['micro-tenant.use-db-name' => true]);
        if (app()->environment('local')) {
            $commands = Artisan::all();
            if (array_key_exists('octane:reload-workers', $commands)) {
                Artisan::call('octane:reload-workers');
            }
        }

        parent::__construct();
    }
}