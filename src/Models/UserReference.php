<?php

namespace Projects\Hq\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Hanafalah\ModuleLicense\Concerns\HasModelHasLicense;
use Hanafalah\ModuleUser\Models\User\UserReference as UserUserReference;

class UserReference extends UserUserReference
{
    use HasModelHasLicense;
}
