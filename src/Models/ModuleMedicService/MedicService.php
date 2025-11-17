<?php

namespace Projects\Hq\Models\ModuleMedicService;

use Projects\Hq\Models\CentralUnicode;
use Hanafalah\ModuleMedicService\Resources\MedicService\{ViewMedicService, ShowMedicService};

class MedicService extends CentralUnicode
{
    protected $table = 'unicodes';

    public function isUsingService(): bool{
        return false;
    }

    public function getViewResource(){
        return ViewMedicService::class;
    }

    public function getShowResource(){
        return ShowMedicService::class;
    }
}
