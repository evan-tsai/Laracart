<?php


namespace EvanTsai\Laracart\Gateways;


use EvanTsai\Laracart\Models\Order;
use Illuminate\Http\Request;

interface PaymentContract
{
    public function checkOut(Order $order);

    public function callback(Order $order, Request $request);
}
