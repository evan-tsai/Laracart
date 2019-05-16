<?php


namespace EvanTsai\Laracart\Modules;


use EvanTsai\Laracart\Modules\Contracts\OrderContract;
use EvanTsai\Laracart\Modules\Traits\Checkout;
use EvanTsai\Laracart\Modules\Traits\PlaceOrder;

class OrderModule implements OrderContract
{
    use Checkout, PlaceOrder;

    protected $order;

    public function __construct()
    {
        $orderClass = $this->getOrderClass();

        $this->order = new $orderClass;
    }

    protected function getOrderClass()
    {
        return config('laracart.models.order');
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
}
