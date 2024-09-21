namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    public function charge($amount);
}