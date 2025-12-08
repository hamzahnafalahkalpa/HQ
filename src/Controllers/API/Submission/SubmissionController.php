<?php

namespace Projects\Hq\Controllers\API\Submission;

use Projects\Hq\Requests\API\ProductService\Submission\{
    ViewRequest, ShowRequest, StoreRequest, DeleteRequest
};

class SubmissionController extends EnvironmentController{
    public function index(ViewRequest $request){
        return $this->getPosTransactionPaginate();
    }

    public function show(ShowRequest $request){
        return $this->showPosTransaction();
    }

    public function store(StoreRequest $request){
        $this->userAttempt();
        $user = $this->global_user;

        $tagihan_name = $user->name;
        if (isset(request()->transaction_item)){
            $transaction_item = request()->transaction_item;
            $transaction_item['item_type'] = 'Workspace';
            $item_payload = &$transaction_item['item'];
            $item_payload['owner_id'] = $user->getKey();
            $timezone = $this->TimezoneModel()->findOrFail($item_payload['setting']['timezone_id']);
            $item_payload['setting']['timezone'] = $timezone->toViewApi()->resolve();            
            $item_payload['integration'] = [
                "satu_sehat" => [
                    "progress" => 0,
                    "general" => [
                        "ihs_number" => null
                    ],
                    "syncs" => [
                        [
                            'flag' => 'encounter',
                            'label' => 'Kunjungan',
                        ],
                        [
                            'flag' => 'condition',
                            'label' => 'Diagnosa',
                        ], 
                        [
                            'flag' => 'dispense',
                            'label' => 'Resep',
                        ]
                    ]
                ],
                "bpjs" => [
                    "progress" => 0,
                    "syncs" => [
                        [
                            'flag' => 'encounter',
                            'label' => 'Kunjungan',
                        ],
                        [
                            'flag' => 'condition',
                            'label' => 'Diagnosa',
                        ], 
                        [
                            'flag' => 'dispense',
                            'label' => 'Resep',
                        ]
                    ]
                ]
            ];
            $product = $this->ProductModel()->findOrFail($transaction_item['item']['product_id']);
            $discount = $product->price * $product->discount/100;
            $payment_detail = $transaction_item['payment_detail'] ?? [
                'id' => null,
                'payment_summary_id'  => null,
                'transaction_item_id' => null,
                'qty'        => 1,
                'price'      => $product->price,
                'amount'     => $product->price,
                'debt'       => $product->price - $discount,
                'discount'   => $discount,
                'cogs'       => 0
            ];
            $transaction_item['payment_detail'] = $payment_detail;
            request()->merge(['transaction_item' => $transaction_item]);
            
            $tagihan_name = $product->name;

            $form = $item_payload['form'];
            $amount = 0;
            if (isset($form['additional_items']) && count($form['additional_items']) > 0){
                $transaction_items = [];
                foreach ($form['additional_items'] as $additional_item) {
                    $new_transaction_item = [
                        'item_type' => 'ProductItem',
                        'item_id'   => $additional_item['id'],
                        'dynamic_forms' => []
                    ];

                    $product_item = $this->ProductItemModel()->findOrFail($new_transaction_item['item_id']);
                    $new_transaction_item['name'] = $product_item->name;
                    $dynamic_forms = $additional_item['dynamic_forms'] ?? [];
                    foreach ($dynamic_forms as $dynamic_form) {
                        switch ($dynamic_form['key']) {
                            case 'medic_service_id': $qty = count($dynamic_form['value'] ?? []);break;
                            case 'user_count'      : $qty = $dynamic_form['value'] ?? 1;break;
                        }
                    }
                    $qty ??= 1;
                    $payment_detail = [
                        'id' => null,
                        'payment_summary_id'  => null,
                        'transaction_item_id' => null,
                        'qty'        => $qty ?? 1,
                        'price'      => $product_item->price,
                        'amount'     => $total_price = $product_item->price * $qty,
                        'debt'       => $total_price,
                        'cogs'       => 0
                    ];
                    $amount += $product_item->price * $qty;
                    $new_transaction_item['payment_detail'] = $payment_detail;
                    $transaction_items[] = $new_transaction_item;
                }
            }
        }

        if (!isset(request()->submission)){
            $submission = [
                'id' => null,
                'name' => 'Registration',
                'flag' => 'MAIN',
                'payment_summary' => [
                    'id' => null,
                    'name'           =>  trim('Total Tagihan Pembelian '.($tagihan_name ?? '')),
                    'reference_type' => 'Submission'
                ]
            ];
            request()->merge(['reference' => $submission]);
        }

        if (!isset(request()->consument)){
            $consument = [
                'id' => null,
                'name' => $user->name,
                'phone' => $user->phone,
                'reference_type' => $user->getMorphClass(),
                'reference_id' => $user->getKey()
            ];
            request()->merge(['consument' => $consument]);
        }

        $name = request()->reference['name'];
        request()->merge([
            'name' => $name ?? 'Registration Submission',
            'transaction_items' => $transaction_items ?? [],
            'billing' => [
                'author_type' => $user->getMorphClass(),
                'author_id'   => $user->getKey(),
                'reporting'   => false,
                'debt'        => (($product->price ?? 0) - ($discount ?? 0)) + $amount,
                'amount'      => ($product->price ?? 0) + $amount,
                'discount'    => $discount ?? 0,
                'invoices'    => [
                    [
                        'id' => null,
                        'reporting' => false,
                        'author_type' => 'User',
                        'author_id'   => $user->getKey(),
                        'payer_type' => 'User',
                        'payer_id'   => $user->getKey(),
                        'payment_history' => [
                            'id' => null,
                            'discount' => 0,
                            'form' => [
                                'payment_summaries' => []
                            ]
                        ]   
                    ]
                ]
            ]
        ]);
        return $this->storePosTransaction();
    }

    public function delete(DeleteRequest $request){
        return $this->deletePosTransaction();
    }
}