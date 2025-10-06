<?php

namespace Projects\Hq\Data;

use Hanafalah\ModulePayer\Data\CompanyData as ModulePayerDataCompanyData;
use Hanafalah\ModuleRegional\Contracts\Data\AddressData;
use Projects\Hq\Contracts\Data\CompanyData as DataCompanyData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Email;

class CompanyData extends ModulePayerDataCompanyData implements DataCompanyData
{
    #[MapInputName('nib')]
    #[MapName('nib')]
    public ?string $nib = null;

    #[MapInputName('email')]
    #[MapName('email')]
    #[Email]
    public ?string $email = null;

    #[MapInputName('phone')]
    #[MapName('phone')]
    public ?string $phone = null;

    #[MapInputName('business_description')]
    #[MapName('business_description')]
    public ?string $business_description = null;

    #[MapInputName('address')]
    #[MapName('address')]
    public ?AddressData $address = null;

    // #[MapInputName('address')]
    // #[MapName('address')]
    // public ?AddressData $address = null;
}