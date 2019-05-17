<?php


namespace EvanTsai\Laracart\Gateways;


use EvanTsai\Laracart\Models\Order;
use Illuminate\Http\Request;

abstract class PaymentGateway
{
    protected $callbackRoute;

    protected $redirectRoute;

    public function __construct()
    {
        $this->callbackRoute = route('laracart.callback', ['gateway' => $this->getGatewayKey()]);
        $this->redirectRoute = route(config('laracart.callback_redirect_route'));
    }

    abstract public function getOrderIdField();

    abstract public function getGatewayKey();

    abstract public function checkOut(Order $order);

    abstract public function callback(Order $order, Request $request);
}
