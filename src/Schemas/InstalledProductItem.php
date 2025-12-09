<?php

namespace Projects\Hq\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\InstalledProductItem as ContractsInstalledProductItem;
use Projects\Hq\Contracts\Data\InstalledProductItemData;

class InstalledProductItem extends PackageManagement implements ContractsInstalledProductItem
{
    protected string $__entity = 'InstalledProductItem';
    public $installed_product_item_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'installed_product_item',
            'tags'     => ['installed_product_item', 'installed_product_item-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreInstalledProductItem(InstalledProductItemData $installed_product_item_dto): Model{
        $add = [
            'name' => $installed_product_item_dto->name,
            'price' => $installed_product_item_dto->price,            
            'actual_price' => $installed_product_item_dto->actual_price,
            'total_price' => $installed_product_item_dto->total_price,
            'discount' => $installed_product_item_dto->discount,
            'qty' => $installed_product_item_dto->qty,
            'status' => $installed_product_item_dto->status,
        ];

        if (isset($installed_product_item_dto->id)) {
            $guard  = ['id' => $installed_product_item_dto->id];
        }else{
            $guard = [
                'product_item_id' => $installed_product_item_dto->product_item_id,
                'reference_id'   => $installed_product_item_dto->reference_id,
                'reference_type' => $installed_product_item_dto->reference_type,
                'submission_id' => $installed_product_item_dto->submission_id
            ];
        }
        $create = [$guard, $add];
        $installed_product_item = $this->usingEntity()->updateOrCreate(...$create);

        // if ($installed_product_item->product_item['flag'] == 'Add'){
        //     if ($installed_product_item->product_item['label'] == 'User'){
        //         $now = now();
        //         $this->schemaContract('license')->prepareStoreLicense($this->requestDTO(config('app.contracts.LicenseData'),[
        //             'reference_type'    => $installed_product_item->reference_type,
        //             'reference_id'      => $installed_product_item->reference_id,
        //             'name' => null,
        //             'expired_at'        => $now->addMonth(),
        //             'last_paid'         => $now,
        //             'billing_generated_at' => $now,
        //             'is_billing_generated' => false,
        //             'status'            => 'ACTIVE',
        //             'recurring_type'    => 'MONTHLY',
        //             'flag'              => 'USER_LICENSE',
        //         ]));
        //     }
        // }

        $this->fillingProps($installed_product_item,$installed_product_item_dto->props);
        $installed_product_item->save();
        return $this->installed_product_item_model = $installed_product_item;
    }
}