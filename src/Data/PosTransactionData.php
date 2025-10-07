<?php

namespace Projects\Hq\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Projects\Hq\Contracts\Data\PosTransactionData as DataPosTransactionData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PosTransactionData extends Data implements DataPosTransactionData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}