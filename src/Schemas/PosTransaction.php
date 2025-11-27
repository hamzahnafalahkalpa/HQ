<?php

namespace Projects\Hq\Schemas;

use Hanafalah\ModulePayment\Schemas\PosTransaction as SchemasPosTransaction;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\PosTransaction as ContractsPosTransaction;
use Illuminate\Support\Str;

use Xendit\{
    Invoice\InvoiceApi,
    Invoice\CreateInvoiceRequest,
    XenditSdkException
};

class PosTransaction extends SchemasPosTransaction implements ContractsPosTransaction
{
    protected string $__entity = 'PosTransaction';
    public $pos_transaction_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'pos_transaction',
            'tags'     => ['pos_transaction', 'pos_transaction-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePosTransaction(mixed $pos_transaction_dto): Model{
        $pos_transaction = parent::prepareStorePosTransaction($pos_transaction_dto);
        $this->fillingProps($pos_transaction,$pos_transaction_dto->props);
        $pos_transaction->save();
        $payment_summary = $pos_transaction->paymentSummary;
        $payment_summary->refresh();

        $billing = $pos_transaction->billing;

        $xendit_invoice = new InvoiceApi();
        // $create_invoice_request = new CreateInvoiceRequest([
        //     'external_id' => $payment_summary->getKey(),
        //     'description' => $payment_summary->name,
        //     'amount' => $payment_summary->amount,
        //     'invoice_duration' => 172800,
        //     'currency' => 'IDR',
        //     'reminder_time' => 2
        // ]);
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => $billing->getKey(),
            'description' => $payment_summary->name,
            'amount' => $payment_summary->amount,
            'invoice_duration' => 172800,
            'currency' => 'IDR',
            'reminder_time' => 2
        ]);
        $for_user_id = null;
        try {
            $result = $xendit_invoice->createInvoice($create_invoice_request, $for_user_id);
            $result = $result->jsonSerialize();
            // $payment_summary->xendit = $result;
            // $payment_summary->save();
            $billing->xendit = $result;
            $billing->save();
        } catch (XenditSdkException $e) {
            echo 'Exception when calling InvoiceApi->createInvoice: ', $e->getMessage(), PHP_EOL;
            echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
        }
        return $this->pos_transaction_model = $pos_transaction;
    }
}