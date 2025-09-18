<?php

namespace Projects\HQ\Controllers;

use App\Http\Controllers\Controller as MainController;
use Projects\HQ\Concerns\HasUser;

abstract class Controller extends MainController
{
    use HasUser;
}
