<?php


namespace EvanTsai\Laracart\Gateways;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class PaymentGateway
{
    protected $callbackRoute;

    protected $redirectRoute;

    public function __construct()
    {
        $this->callbackRoute = route(config('laracart.callback_route'), ['gateway' => $this->getGatewayKey()]);
        $this->redirectRoute = route(config('laracart.callback_redirect_route'));
    }

    abstract public function getOrderIdField();
    abstract public function getGatewayKey();
    abstract public function checkOut(Model $order);
    abstract public function callback(Model $order, Request $request);
}
