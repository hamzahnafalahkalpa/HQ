<?php

namespace Projects\Hq\Controllers\API\ProductService\Submission;

use Projects\Hq\Requests\API\ProductService\Submission\{
    ViewRequest, ShowRequest, StoreRequest, DeleteRequest
};

class SubmissionController extends EnvironmentController{
    protected function commonRequest(){
        parent::commonRequest();
        $this->userAttempt();
        $billing = request()?->billing;
        if (isset($billing)){
            $billing['author_type']  ??= $this->global_user->getMorphClass();   
            $billing['author_id']    ??= $this->global_user->getKey();   
        }

        request()->merge([
            'search_reference_type' => ['Submission'],
            'billing'               => $billing ?? null
        ]);
    }

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
            $payment_detail = $transaction_item['payment_detail'] ?? [
                'id' => null,
                'payment_summary_id'  => null,
                'transaction_item_id' => null,
                'qty'        => 1,
                'price'      => $product->price,
                'amount'     => $product->price,
                'debt'       => $product->price,
                'cogs'       => 0
            ];
            $transaction_item['payment_detail'] = $payment_detail;
            request()->merge(['transaction_item' => $transaction_item]);
            $tagihan_name = $product->name;
        }

        if (!isset(request()->submission)){
            $submission = [
                'id' => null,
                'name' => 'Registration',
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
            'billing' => [
                'author_type' => $user->getMorphClass(),
                'author_id'   => $user->getKey()
            ]
        ]);
        return $this->storePosTransaction();
    }

    public function delete(DeleteRequest $request){
        return $this->deletePosTransaction();
    }
}