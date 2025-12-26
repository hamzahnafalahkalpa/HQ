<?php

namespace Projects\Hq\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Hanafalah\ApiHelper\Concerns\Token\HasApiTokens;
use Hanafalah\ModuleUser\Models\User\User as UserUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

use Projects\Hq\Transformers\ModuleUser\ShowUser;
use Projects\Hq\Transformers\ModuleUser\ViewUser;

class User extends UserUser
{
    use HasFactory, Notifiable, HasApiTokens;

    public function workspace(){
        return $this->hasOneModel('Workspace', 'owner_id');
    }

    public function workspaces(){
        return $this->hasManyModel('Workspace', 'owner_id');
    }

    public function getViewResource(){
        return ViewUser::class;
    }

    public function getShowResource(){
        return ShowUser::class;
    }
}
