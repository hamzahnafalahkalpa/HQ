<?php

namespace Projects\Hq\Concerns;

use Hanafalah\ApiHelper\Facades\ApiAccess;

trait HasUser
{
    public $global_user;
    public $global_employee;
    public $global_room;
    public $global_user_reference;
    public $global_workspace;

    public function userAttempt()
    {
        $user = ApiAccess::getUser();
        $this->global_user = $user;
        if (isset($user)){
            $user->load([
                'userReference' => function($query){
                    $query->with([
                        'role'
                    ])->where('reference_type', $this->EmployeeModelMorph());
                }
            ]);
            $user_reference = $user->userReference;
            if (isset($user_reference)){
                $this->global_user_reference = &$user_reference;
    
                $workspace = &$user_reference->workspace;
                if(isset($workspace)) {
                    $this->global_workspace = $workspace;
    
                    if (isset($workspace->setting)){
                        $setting = $workspace->setting;
                    }
                }
                $impersonate = config()->get('app.impersonate');
                config()->set('app.impersonate', $this->mergeArray($impersonate,[
                    'auth'      => $user,
                    'workspace' => $workspace ?? null,
                ]));
            }
        }
        parent::__construct();
    }
}