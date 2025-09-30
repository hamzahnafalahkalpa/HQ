<?php

namespace Projects\Hq\Facades;

class Hq extends \Illuminate\Support\Facades\Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return \Projects\Hq\Contracts\Hq::class;
  }
}
