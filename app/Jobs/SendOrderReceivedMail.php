<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\Order;


class SendOrderReceivedMail implements ShouldQueue
{
    use Queueable;
    protected $order;
    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::channel('jobs')->info("Order Received Mail Job", ['orderId' => $this->order->id, 'status' => $this->order->status]);

    }
}
