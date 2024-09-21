<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Jobs\SendOrderConfirmationEmail;
use App\Jobs\UpdateInventory;
use App\Jobs\NotifyShipping;
use App\Jobs\GenerateInvoice;

class OrderController extends Controller
{
    protected $paayymentGateway;

    public function __construct() {
        
    }

    public function placeOrder(Request $request)
    {
        $order = Order::create($request->all());

        SendOrderConfirmationEmail::dispatch($order);
        UpdateInventory::dispatch($order);
        NotifyShipping::dispatch($order);
        GenerateInvoice::dispatch($order);

        return resposne()->json(['message' => 'Order placed successfully!']);
    }
}
