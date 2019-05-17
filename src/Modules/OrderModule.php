<?php


namespace EvanTsai\Laracart\Modules;


use EvanTsai\Laracart\Gateways\PaymentGateway;
use EvanTsai\Laracart\Modules\Contracts\OrderContract;
use EvanTsai\Laracart\Modules\Traits\Checkout;
use EvanTsai\Laracart\Modules\Traits\PlaceOrder;
use EvanTsai\Laracart\Modules\Traits\ProcessOrder;

class OrderModule implements OrderContract
{
    use Checkout, PlaceOrder, ProcessOrder;

    protected $order;

    public function __construct()
    {
        $orderClass = $this->getOrderClass();

        $this->order = new $orderClass;
    }

    public function for($id)
    {
        $order = call_user_func($this->getOrderClass() . '::find', $id);

        if (!$order) {
            throw new \ErrorException('Order not found');
        }

        $this->order = $order;

        return $this;
    }

    protected function getOrderClass()
    {
        return config('laracart.models.order');
    }

    public function getOrder()
    {
        return $this->order;
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
