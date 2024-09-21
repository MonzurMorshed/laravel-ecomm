<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank you for your order!</h1>
    <p>Order Number: {{ $order->order_number }}</p>
    <p>Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
    
    <h2>Order Details:</h2>
    <ul>
        @foreach(json_decode($order->items) as $item)
            <li>{{ $item->name }} (x{{ $item->quantity }}) - ${{ number_format($item->price, 2) }}</li>
        @endforeach
    </ul>
    
    <p>We will notify you once your order is shipped!</p>
    <p>Thank you for shopping with us!</p>
</body>
</html>
