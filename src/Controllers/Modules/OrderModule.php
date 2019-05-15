<?php


namespace EvanTsai\Laracart\Controllers\Modules;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class OrderModule
{
    public $order;

    public function __construct()
    {
        $orderClass = $this->getOrderClass();

        $this->order = new $orderClass;
    }

    protected function getOrderClass()
    {
        return config('laracart.models.order');
    }

    public function for(Model $order)
    {
        if ($order && !is_a($order, $this->getOrderClass())) {
            throw new \UnexpectedValueException('Model is not a ' . $this->getOrderClass());
        }

        $this->order = $order;

        return $this;
    }

    public function placeOrder($request)
    {
        $request->validate(array_merge(
            ['cart' => 'required|json'],
            config('laracart.order_validation')
        ));

        if (config('laracart.models.user')) {
            $this->order->user_id = Auth::id();
        }

        foreach ($request->except(['cart']) as $key => $value) {
            if (Schema::hasColumn(config('laracart.tables.order'), $key)) {
                $this->order->{$key} = $value;
            }
        }

        $this->order->save();

        $products = collect(json_decode($request->cart, true));

        $products = $products->mapWithKeys(function ($item) {
            return [$item['id'] => ['quantity' => $item['quantity']]];
        });

        $this->order->products()->sync($products);
    }
}
