<?php

namespace Projects\HQ\Facades;

class HQ extends \Illuminate\Support\Facades\Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return \Projects\HQ\Contracts\HQ::class;
  }
}
