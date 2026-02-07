<?php

namespace App\Services\Payments; 
use Illuminate\Support\Facades\Log;

class CreditCardGateway implements PaymentGatewayInterface { 

    public function process(array $paymentData): array { 
                
        //I have chose to make these 3 private called methods instead of interface as they may be not used in some gateways
        //rather than that they may be defined in the interface itself

        //prepare payment request body
        $body = $this->buildBody($paymentData);

        //process the payment transaction
        $transaction = $this->makeTransaction($body);

        //sending either email or sms for payment confirmation
        $email = $this->sendEmail($transaction);

        //or This can be replaced with another strategy for different sms providers
        // $sms = $this->sendSMS($transaction);  

        return $transaction; 

    }


    private function buildBody($paymentData)
    {
        $body = [
            //gateway info
            'creditCardUrl' => config('payment.CREDITCARD_URL'),
            'creditCardKey' => config('payment.CREDITCARD_KEY'),
            'creditCardSecret' => config('payment.CREDITCARD_SECRET'),
            'CreditCardMerchantId' => config('payment.CREDITCARD_MERCHANTID'),

            //order info
            'amount' => $paymentData['order_Info']['total'],
            'orderId' =>$paymentData['order_Info']['id'],

            //user info
            'userId' => $paymentData['order_user_Info']['id'],
            'userName' => $paymentData['order_user_Info']['name'],
            'userEmail' => $paymentData['order_user_Info']['email'],

            //transaction info
            'transaction_id' => 'CreditCard-' . uniqid()

        ];

        Log::channel('payment')->info("CREDIT CARD Payment Body", ['userId' => $body['userId'], 'amount' => $body['amount']]);

        return $body ;
    }


    private function makeTransaction($body)
    {
        // Here will be the actual logic for integration and transaction process with gateway

        $body['transactionStatus'] = 'successful';
        Log::channel('payment')->info("CREDIT CARD Payment Transaction process", ['transaction_status' => $body['transactionStatus'], 'amount' => $body['amount']]);

        return $body ;
    }

    private function sendEmail($transaction)
    {
        try {
            //Here will be the logic of sending either email or sms for payment process confirmation
            Log::channel('payment')->info("CREDIT CARD Payment Email", ['status' => 'sended successfully']);

        } catch (\Throwable $e) {
            Log::channel('payment')->info("CREDIT CARD Payment, Failed to sent Email with excpetion: " . $e->getMessage());
        }
    }

}