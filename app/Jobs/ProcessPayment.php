<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

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
        $paymentStatus = $this->processPayment($this->order);

        $paymentStatus == 'success' ?? $this->order->update(['status' => 'paid']);
    }

    public function processPayment(Order $order)
    {
        $paymentData = [
            'amount' => $order->total_amount,
            'currency' => 'USD',
            'payment_method' => $order->payment_method,
            'order_id' => $order->id
        ];

        try {
            $response = PaymentGateway::charge($paymentData);

            return $response->status == 'succeeded' ? 'success' : 'failed';

        } catch(\Exception $e) {
            return 'failed';
        }

    }
}
