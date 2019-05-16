<?php


namespace EvanTsai\Laracart\Gateways;


use Illuminate\Database\Eloquent\Model;

abstract class PaymentGateway
{
    protected $callbackRoute;

    public function __construct()
    {
        $this->callbackRoute = route(config('laracart.callback_route'));
    }

    abstract public function checkOut(Model $order);


}
