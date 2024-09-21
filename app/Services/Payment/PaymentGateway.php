<?php

namespace App\Services\Payment;
use App\Models\PaymentGateway as PaymentGatewayModel;

class PaymentGateway implements PaaymentGatewayInterface
{
    public function charge($amount,$gatewayId)
    {
        $gatewayData = PaymentGatewayModel::findOrFail($gatewayId);
        return "Charging $gatewayData->amount using $gatewayData->name";
    }

}