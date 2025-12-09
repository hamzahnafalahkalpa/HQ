<?php

namespace Projects\Hq\Data;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Hanafalah\ModuleWorkspace\Contracts\Data\WorkspaceData as ContractsDataWorkspaceData;
use Hanafalah\ModuleWorkspace\Data\WorkspaceData as DataWorkspaceData;
use Hanafalah\LaravelFeature\Data\InstalledFeatureData;
use Projects\Hq\Data\InstalledProductItemData;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class WorkspaceData extends DataWorkspaceData implements ContractsDataWorkspaceData{
    use HasRequestData;

    #[MapInputName('product_id')]
    #[MapName('product_id')]
    public mixed $product_id = null;

    #[MapInputName('submission_id')]
    #[MapName('submission_id')]
    public mixed $submission_id = null;

    #[MapInputName('submission_model')]
    #[MapName('submission_model')]
    public ?object $submission_model = null;

    #[MapInputName('product_model')]
    #[MapName('product_model')]
    public ?object $product_model = null;

    #[MapInputName('form')]
    #[MapName('form')]
    public ?array $form = null;

    #[MapInputName('installed_features')]
    #[MapName('installed_features')]
    #[DataCollectionOf(InstalledFeatureData::class)]
    public ?array $installed_features = null;

    #[MapInputName('installed_product_items')]
    #[MapName('installed_product_items')]
    #[DataCollectionOf(InstalledProductItemData::class)]
    public ?array $installed_product_items = null;

    public static function before(array &$attributes){
        $new = self::new();
        if (isset($attributes['product_id'])){
            $product = $new->ProductModel()->with('productItems')->findOrFail($attributes['product_id']);
            $attributes['product_model'] = $product;

            if (isset($attributes['form'])){
                $attributes['installed_product_items'] ??= [];
                $installed_product_item_dto = &$attributes['installed_product_items'];

                $form = $attributes['form'];
                $form_product_items = &$form['product_items'];
                $form_product_items_ids = array_column($form_product_items, 'id');

                $attributes['installed_features'] ??= [];
                foreach ($product->productItems as $productItem) {
                    $installed_data_dto = [
                        'product_item_id' => $productItem->getKey(),
                        'submission_id'   => $attributes['submission_id'] ?? null,
                        "qty"             => 1,
                        'status'          => 'DRAFT'
                    ];
                    $src = array_search($productItem->getKey(), $form_product_items_ids);
                    if (is_numeric($src)) {
                        $form_product_item = &$form_product_items[$src];
                        if (isset($form_product_item['dynamic_forms']) && count($form_product_item['dynamic_forms']) > 0){
                            $installed_features = &$attributes['installed_features'];
                            foreach ($form_product_item['dynamic_forms'] as $dynamic_form) {
                                $key_value = $dynamic_form['key'];
                                $feature_type = null;
                                switch ($key_value) {
                                    case 'medic_service_id':
                                        if (!is_array($dynamic_form['value'])){
                                            $dynamic_form['value'] = [$dynamic_form['value']];                                            
                                        }
                                        $feature_type = 'MedicService';
                                    break;
                                    case 'user_count':
                                        $installed_data_dto['qty'] = intval($dynamic_form['value']);
                                    break;
                                }
                                if (isset($feature_type)){
                                    $installed_data_dto['qty']--;
                                    foreach ($dynamic_form['value'] as $dynamic_value) {
                                        $installed_data_dto['qty']++;
                                        $model = $new->{$feature_type.'Model'}()->findOrFail($dynamic_value);
                                        $installed_features[] = [
                                            'name' => $model->name ?? 'Unknown Feature',
                                            'master_feature_type' => $feature_type,
                                            'master_feature_id'   => $dynamic_value,
                                        ];
                                    }
                                }
                            }
                        }
                    }
                    $installed_product_item_dto[] = $installed_data_dto;
                }

                foreach ($form['additional_items'] as $additional_item) {
                    $productItem = $new->ProductItemModel()->findOrFail($additional_item['id']);
                    $installed_data_dto = [
                        'product_item_id' => $productItem->getKey(),
                        'submission_id'   => $attributes['submission_id'] ?? null,
                        "qty"             => 1,
                        'status'          => 'DRAFT'
                    ];
                    $form_product_item = $additional_item;
                    if (isset($form_product_item['dynamic_forms']) && count($form_product_item['dynamic_forms']) > 0){
                        $installed_features = &$attributes['installed_features'];
                        foreach ($form_product_item['dynamic_forms'] as $dynamic_form) {
                            $key_value = $dynamic_form['key'];
                            $feature_type = null;
                            switch ($key_value) {
                                case 'medic_service_id':
                                    if (!is_array($dynamic_form['value'])){
                                        $dynamic_form['value'] = [$dynamic_form['value']];                                            
                                    }
                                    $feature_type = 'MedicService';
                                break;
                                case 'user_count':
                                    $installed_data_dto['qty'] = intval($dynamic_form['value']);
                                break;
                            }
                            if (isset($feature_type)){
                                $installed_data_dto['qty']--;
                                foreach ($dynamic_form['value'] as $dynamic_value) {
                                    $installed_data_dto['qty']++;
                                    $model = $new->{$feature_type.'Model'}()->findOrFail($dynamic_value);
                                    $installed_features[] = [
                                        'name' => $model->name ?? 'Unknown Feature',
                                        'master_feature_type' => $feature_type,
                                        'master_feature_id'   => $dynamic_value,
                                    ];
                                }
                            }
                        }
                    }
                    $installed_product_item_dto[] = $installed_data_dto;
                }
            }
            $attributes['prop_product'] = $product->toViewApi()->resolve();
        }
    }
}