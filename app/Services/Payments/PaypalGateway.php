<?php

namespace App\Services\Payments; 

class PaypalGateway implements PaymentGatewayInterface { 

    public function process(array $paymentData): array { 

        return [ 'status' => 'successful', 'transaction_id' => 'Paypal-' . uniqid() ]; 

    }

}