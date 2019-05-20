<?php


namespace EvanTsai\Laracart\Modules\Traits;


use Illuminate\Http\Request;

trait ProcessOrder
{
    public function processOrder($orderId, Request $request)
    {
        $order = $this->for($orderId)->getModel();

        $paymentClass = $this->getGatewayClass($order->payment_gateway);

        return $paymentClass->callback($order, $request);
    }
}
