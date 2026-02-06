<?php

namespace App\Services\Payments;

class PaymentService
{
    protected $gateway;

    public function __construct(PaymentGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function process(array $paymentData): array
    {
        return $this->gateway->process($paymentData);
    }
}
