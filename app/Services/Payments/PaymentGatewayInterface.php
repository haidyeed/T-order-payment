<?php
namespace App\Services\Payments; 

interface PaymentGatewayInterface { 

    public function process(array $paymentData): array; 
    
}