<?php

namespace App\Services\Payments; 

class CreditCardGateway implements PaymentGatewayInterface { 

    public function process(array $paymentData): array { 

        return [ 'status' => 'successful', 'transaction_id' => 'CreditCard-' . uniqid() ]; 

    }

}