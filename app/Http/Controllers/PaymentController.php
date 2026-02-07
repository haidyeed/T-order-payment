<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; 
use App\Models\Payment; 
use App\Services\Payments\CreditCardGateway; 
use App\Services\Payments\PaypalGateway; 
use App\Services\Payments\PaymentService; 
use App\Http\Requests\ProcessPaymentRequest;


class PaymentController extends Controller
{
    public function processPayment(ProcessPaymentRequest $request, $orderId) { 

        $order = Order::find($orderId); 

        if(!$order){
            return response()->json(['error' => 'this Order does not exist'], 404); 
        }

        if ($order->status !== 'confirmed') { 
            return response()->json(['error' => 'Order is not confirmed yet'], 400); 
        } 
        
        $method = $request->input('method'); 

        // I have tried to lock it from DB via order id method uniqueness
        // but what in case status was failed many times for same order id and method ! 
        ##TODO:: Idempotency Keys 
        if (Payment::where('order_id', $orderId)->where('method', $method)->where('status','successful')->exists()) { 
            return response()->json([ 'error' => 'Payment already exists successfully for this order with this method.' ], 400); 
        }

        // Select gateway
        $gateway = match ($method) { 
            'credit_card' => new CreditCardGateway(), 
            'paypal' => new PaypalGateway(), 
            default => null
        }; 

        if (!$gateway) { 
            return response()->json(['error' => 'Unsupported payment method'], 400); 
        } 

        $paymentData = [
            'order_Info' => $order,
            'payment_gateway_Info' => $request->all(),
            'order_user_Info' => $order->user,
            'auth_user_Info' => auth()->user()
        ];
        
        // return response()->json(['error' => $paymentData], 404); 

        $paymentService = new PaymentService($gateway); 
        
        $result = $paymentService->process($paymentData); 
        $payment = Payment::create([ 'order_id' => $order->id, 'status' => $result['transactionStatus'], 'method' => $method, 'transaction_id' => $result['transaction_id'] ]); 

        return response()->json($payment, 201); 

    }


    public function viewPayments($orderId = null) { 
        $payments = $orderId ? Payment::where('order_id', $orderId)->get() : Payment::all(); 
        return response()->json($payments); 
    }

}
