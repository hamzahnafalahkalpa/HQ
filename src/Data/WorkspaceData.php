<?php

namespace Projects\Hq\Data;

use Hanafalah\ModuleWorkspace\Contracts\Data\WorkspaceData as ContractsDataWorkspaceData;
use Hanafalah\ModuleWorkspace\Data\WorkspaceData as DataWorkspaceData;
use Projects\Hq\Data\InstalledProductItemData;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class WorkspaceData extends DataWorkspaceData implements ContractsDataWorkspaceData{
    #[MapInputName('product_id')]
    #[MapName('product_id')]
    public mixed $product_id = null;

    #[MapInputName('product_model')]
    #[MapName('product_model')]
    public ?object $product_model = null;

    #[MapInputName('installed_product_items')]
    #[MapName('installed_product_items')]
    #[DataCollectionOf(InstalledProductItemData::class)]
    public ?array $installed_product_items = null;

    public static function before(array &$attributes){
        $new = self::new();
        if (isset($attributes['product_id'])){
            $product = $new->ProductModel()->findOrFail($attributes['product_id']);
            $attributes['product_model'] = $product;
            $attributes['prop_product'] = $product->toViewApi()->resolve();
        }
    }
}