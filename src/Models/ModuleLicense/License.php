<?php

namespace Projects\Hq\Models\ModuleLicense;

use Hanafalah\ModuleLicense\Models\License as ModelsLicense;

class License extends ModelsLicense
{
    public function viewUsingRelation(): array{
        return [
            'modelHasLicense.model.reference'
        ];
    }

    public function showUsingRelation(): array{
        return [
            'reference','modelHasLicense.model.reference'
        ];
    }
}
