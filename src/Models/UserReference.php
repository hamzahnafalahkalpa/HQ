<?php

namespace Projects\Hq\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Hanafalah\LaravelHasProps\Concerns\HasCurrent;
use Hanafalah\ModuleLicense\Concerns\HasModelHasLicense;
use Hanafalah\ModuleUser\Models\User\UserReference as UserUserReference;

class UserReference extends UserUserReference
{
    use HasModelHasLicense, HasCurrent;

    protected $list = [
        'id','uuid','reference_type','reference_id',
        'user_id','workspace_type','workspace_id','current',
        'flag'
    ];

    protected static function booted(): void{
        parent::booted();
        static::creating(function($query){
            $query->flag = 'HQ';
        });
    }

    public function getConditions(): array{
        return ['reference_type', 'reference_id', 'user_id', 'flag'];
    }   

    public function tenant(){return $this->morphTo(__FUNCTION__, "workspace_type", "workspace_id");}
}
