<?php

namespace Projects\Hq\Data;

use Projects\Hq\Contracts\Data\HqAddressData as DataHqAddressData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Hanafalah\ModuleRegional\Data\AddressData;

class HqAddressData extends AddressData implements DataHqAddressData{}