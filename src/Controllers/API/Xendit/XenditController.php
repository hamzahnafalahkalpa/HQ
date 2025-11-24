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
                    return $data;
                });
            } catch (\Throwable $th) {
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