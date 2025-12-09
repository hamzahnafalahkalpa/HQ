<?php

namespace Projects\Hq\Schemas;

use Hanafalah\ModulePayment\Schemas\PosTransaction as SchemasPosTransaction;
use Hanafalah\ModuleTransaction\Contracts\Data\TransactionItemData;
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

        $reference = $pos_transaction->reference;
        $payment_summary = $pos_transaction->paymentSummary;
        $billing = &$pos_transaction->billing;
        $invoices = &$billing->invoices;
        foreach ($invoices as &$invoice) {
            $payment_history = &$invoice->paymentHistory;
            $form = $payment_history->form;
            $payment_summaries = &$form['payment_summaries'];
            $payment_summary_data = [
                'id' => $payment_summary->getKey(),
                'payment_details' => []
            ];
            foreach ($payment_summary->paymentDetails as $paymentDetail) {
                $payment_summary_data['payment_details'][] = [
                    'id' => $paymentDetail->getKey()
                ];                
            }
            $payment_summaries[] = $payment_summary_data;
            $payment_history->setAttribute('form', $form);
            $payment_history->save();
        }
        $billing->save();
        if ($pos_transaction->reference_type == 'Submission' && $reference->flag == 'ADDITIONAL'){
            $transaction_items = $pos_transaction->transactionItems;
            foreach ($transaction_items as &$form_product_item) {
                $form_product_item_model = $this->ProductItemModel()->findOrFail($form_product_item->item_id);

                $installed_data = [
                    'product_item_id' => $form_product_item_model->getKey(),
                    "qty"             => 1
                ];
                if (isset($form_product_item->dynamic_forms) && count($form_product_item->dynamic_forms) > 0){
                    $installed_features = [];
                    foreach ($form_product_item->dynamic_forms as $dynamic_form) {
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
                                $installed_data['qty'] = intval($dynamic_form['value']);
                            break;
                        }
                        if (isset($feature_type)){
                            $installed_data['qty']--;
                            foreach ($dynamic_form['value'] as $dynamic_value) {
                                $installed_data['qty']++;
                                $model = $this->{$feature_type.'Model'}()->findOrFail($dynamic_value);
                                $installed_features[] = [
                                    'name' => $model->name ?? 'Unknown Feature',
                                    'master_feature_type' => $feature_type,
                                    'master_feature_id'   => $dynamic_value,
                                ];
                            }
                        }
                    }
                }
                $installed_data['installed_features'] = $installed_features;
                $installed_data['submission_id'] = $reference->getKey();
                $installed_data['reference_type'] = $reference->reference_type;
                $installed_data['reference_id'] = $reference->reference_id;
                $this->schemaContract('installed_product_item')
                    ->prepareStoreInstalledProductItem(
                        $this->requestDTO(
                            config('app.contracts.InstalledProductItemData'),
                            $installed_data
                        )
                    );
            }
        }

        $this->fillingProps($pos_transaction,$pos_transaction_dto->props);
        $pos_transaction->save();
        $payment_summary->refresh();

        $xendit_invoice = new InvoiceApi();
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => $billing->getKey(),
            'description' => $payment_summary->name,
            'amount'         => $payment_summary->debt,
            'invoice_duration' => $reference->flag == 'RENEWAL' ? 691200 : 259200,
            'currency' => 'IDR',
            'reminder_time' => 2
        ]);
        $for_user_id = null;
        try {
            $result = $xendit_invoice->createInvoice($create_invoice_request, $for_user_id);
            $result = $result->jsonSerialize();
            $billing->xendit = $result;
            $billing->save();
        } catch (XenditSdkException $e) {
            echo 'Exception when calling InvoiceApi->createInvoice: ', $e->getMessage(), PHP_EOL;
            echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
        }
        return $this->pos_transaction_model = $pos_transaction;
    }

    protected function createTransactionItem(TransactionItemData &$transaction_item_dto, Model &$transaction){
        $reference = $transaction->reference;
        if ($reference->getMorphClass() == 'Submission' && $reference->flag == 'MAIN') {
            $transaction_item_dto->submission_id = $reference->getKey();
            if (isset($transaction_item_dto->item) && $transaction_item_dto->item_type == 'Workspace'){
                $transaction_item_dto->item->submission_model = $reference;
                $transaction_item_dto->item->submission_id = $reference->getKey();
                foreach ($transaction_item_dto->item->installed_product_items as &$installed_product_item) {
                    $installed_product_item->submission_id = $reference->getKey();
                }
            }
        }

        $transaction_item_dto->transaction_id    = $transaction->getKey();
        $transaction_item_dto->transaction_model = $transaction;
        $transaction_item_dto->reference_type = $transaction->reference_type;
        $transaction_item_dto->reference_id = $transaction->reference_id;
        $payment_summary = $transaction->paymentSummary;
        $transaction_item_dto->payment_summary_id = $payment_summary->getKey();
        return $this->schemaContract('transaction_item')->prepareStoreTransactionItem($transaction_item_dto);
    }
}