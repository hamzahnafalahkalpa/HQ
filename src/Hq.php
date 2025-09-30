<?php

namespace Projects\Hq;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\{
    Concerns\Support\HasRepository,
    Supports\PackageManagement,
    Events as SupportEvents
};
use Projects\Hq\Contracts\Hq as ContractsHq;

class Hq extends PackageManagement implements ContractsHq{
    use Supports\LocalPath,HasRepository;

    const LOWER_CLASS_NAME = "hq";
    const SERVICE_TYPE     = "";
    const ID               = "1";

    public ?Model $model;

    public function events(){
        return [
            SupportEvents\InitializingEvent::class => [
                
            ],
            SupportEvents\EventInitialized::class  => [],
            SupportEvents\EndingEvent::class       => [],
            SupportEvents\EventEnded::class        => [],
            //ADD MORE EVENTS
        ];
    }

    protected function dir(): string{
        return __DIR__;
    }
}
