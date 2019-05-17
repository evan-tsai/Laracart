<?php


namespace EvanTsai\Laracart\Gateways;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class PaymentGateway
{
    protected $callbackRoute;

    public function __construct()
    {
        $this->callbackRoute = route(config('laracart.callback_route'));
    }

    abstract public function getOrderIdField();
    abstract public function checkOut(Model $order);
    abstract public function callback(Model $order, Request $request);
}
