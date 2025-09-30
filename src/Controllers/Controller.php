<?php

namespace Projects\Hq\Controllers;

use App\Http\Controllers\Controller as MainController;
use Projects\Hq\Concerns\HasUser;

abstract class Controller extends MainController
{
    use HasUser;
}
