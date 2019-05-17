<?php


namespace EvanTsai\Laracart\Modules;


use EvanTsai\Laracart\Gateways\PaymentGateway;
use EvanTsai\Laracart\Modules\Contracts\OrderContract;
use EvanTsai\Laracart\Modules\Traits\Checkout;
use EvanTsai\Laracart\Modules\Traits\PlaceOrder;
use EvanTsai\Laracart\Modules\Traits\ProcessOrder;

class OrderModule extends BaseModule implements OrderContract
{
    use Checkout, PlaceOrder, ProcessOrder;

    protected function getModelClass()
    {
        return config('laracart.models.order');
    }

    protected function getGatewayClass($gateway)
    {
        $gatewayClassName = config('laracart.gateways.' . $gateway . '.class');
        $gatewayClass = new $gatewayClassName;

        if (!$gatewayClass instanceof PaymentGateway) {
            throw new \UnexpectedValueException($gatewayClassName . ' is not a Payment Gateway');
        }

        return $gatewayClass;
    }
}
