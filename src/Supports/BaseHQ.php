<?php

namespace Projects\HQ\Supports;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Supports\PackageManagement;

class BaseHQ extends PackageManagement implements DataManagement
{
    protected $__config_name = 'h-q';
    protected $__h_q = [];

    /**
     * A description of the entire PHP function.
     *
     * @param Container $app The Container instance
     * @throws Exception description of exception
     * @return void
     */
    public function __construct()
    {
        $this->setConfig($this->__config_name, $this->__h_q);
    }
}
