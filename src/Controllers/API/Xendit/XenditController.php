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
                    $payment_summary = $this->PaymentSummaryModel()->find($data['external_id']);
                    $payment_summary->debt = 0;
                    $payment_summary->xendit = $data;
                    $payment_summary->save();

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