<?php

namespace Projects\Hq\Controllers\API\Xendit;

use Projects\Hq\Controllers\API\ApiController;
use Illuminate\Http\Request;

class XenditController extends ApiController{
    public function store(Request $request){
        \Log::channel('xendit')->info('HQ: Xendit paid callback', [
            'payload' => request()->all(),
            'headers' => request()->headers->all()
        ]);
        $data = request()->all();
        if (isset($data['external_id'])){
            try {
                $data = $this->transaction(function () use ($data) {
                    $billing = $this->BillingModel()->with('hasTransaction.consument')->findOrFail($data['external_id']);
                    $transaction = $billing->hasTransaction;
                    $transaction->load('paymentSummary.paymentDetails');
                    $payment_summary = $transaction->paymentSummary;
                            // 'has_transaction_id' => $transaction->getKey(),
                            // 'reporting' => false,
                            // 'xendit' => $data,
                            // 'debt' => 0,
                            // 'reported_at' => now()   
                    $payment_method = $this->PaymentMethodModel()->where('name','BANK TRANSFER')->first();
                    app(config('app.contracts.Billing'))->prepareStoreBilling(
                        $this->requestDTO(config('app.contracts.BillingData'),[
                            "id" => $billing->getKey(),
                            "reporting" => true, 
                            'xendit' => $data,
                            'has_transaction_id' => $transaction->getKey(),
                            'author_type' => $billing->author_type,
                            'author_id' => $billing->author_id,
                            'debt' => 0,
                            "invoices" => [
                                [
                                    "id"         => null,                
                                    "payer_id"   => $transaction->consument->getKey(), 
                                    "payer_type" => "Consument", 
                                    "reporting" => true,
                                    "payment_history" => [
                                        "id" => null,
                                        "discount" => 0,
                                        "form" => [ //THIS FIELD USING ONLY FOR ARTIFICIAL DATA, WILL REMOVE WHEN DATA SETTLED
                                            "payment_summaries" => [
                                                //YOU CAN USE PAYMENT SUMMARY AND PAYMENT DETAIL RESPONSE WHEN SHOW POS TRANSACTION
                                                [
                                                    "id" => $payment_summary->getKey(),
                                                    "payment_details" => $payment_summary->paymentDetails->map(function($pd){
                                                        return ["id" => $pd->getKey()];
                                                    })->toArray()
                                                ]
                                            ]
                                        ]
                                    ],
                                    "split_payments" => [
                                        [
                                            "id"=> null,
                                            "money_paid" => $payment_summary->amount, //nullable
                                            "payment_method_id" => $payment_method->getKey(),
                                            'payment_method_model' => $payment_method //required, GET FROM AUTOLIST - PAYMENT METHOD LIST                
                                        ]
                                    ]
                                ]
                            ]
                        ])
                    );
                    // $payment_summary = $transaction->paymentSummary;
                    // $payment_summary->debt = 0;
                    // $payment_summary->save();
                    // $billing->xendit = $data;
                    // $billing->debt = 0;
                    // $billing->reported_at = now();
                    // $billing->save();
                    
                    $reference = $payment_summary->reference;
                    $workspace = $reference->workspace;
                    if (isset($workspace)){
                        $workspace->status = 'ACTIVE';
                        $workspace->save();
                        $workspace->load(['product','submission']);
                        app(config('app.contracts.Workspace'))->generateTenant($this->requestDTO(
                            config('app.contracts.WorkspaceData'),
                            [
                                'name' => $workspace->name,
                                'workspace_id' => $workspace->getKey(),
                                'workspace_model' => $workspace,
                                'product_model' => $workspace->product
                            ]
                        ));
                    }
                    return $data;
                });
            } catch (\Throwable $th) {
                dd($th->getMessage());
                throw $th;
            }
        }
        return response()->json([
            'message' => 'Received',
            'payload' => request()->all(),
            'headers' => request()->headers->all(),
            'response' => $data
        ]);
    }
}