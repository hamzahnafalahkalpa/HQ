<?php

namespace Projects\HQ;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\{
    Concerns\Support\HasRepository,
    Supports\PackageManagement,
    Events as SupportEvents
};
use Projects\HQ\Contracts\HQ as ContractsHQ;

class HQ extends PackageManagement implements ContractsHQ{
    use Supports\LocalPath,HasRepository;

    const LOWER_CLASS_NAME = "h-q";
    const SERVICE_TYPE     = "tenant";
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
