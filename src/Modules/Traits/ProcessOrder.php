<?php


namespace EvanTsai\Laracart\Modules\Traits;


use Illuminate\Http\Request;

trait ProcessOrder
{
    public function processOrder(Request $request)
    {
        $paymentClass = $this->getGatewayClass($request->gateway);

        $orderId = $request->{$paymentClass->getOrderIdField()};

        $order = $this->for($orderId)->getModel();

        return $paymentClass->callback($order, $request);
    }
}
