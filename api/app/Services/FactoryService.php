<?php

namespace App\Services;

class FactoryService
{
    public static function createService()
    {
        $paymentTpye = config('app.payment_type');

        switch (strtolower($paymentTpye)) {
            case 'qpay':
                return new QpayService;

            default:
                throw new \InvalidArgumentException("Unsupported payment type: {$paymentTpye}");
        }
    }
}
