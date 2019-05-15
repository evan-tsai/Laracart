<?php


namespace EvanTsai\Laracart\Modules;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class OrderModule
{
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
        $validated = $request->validate(array_merge(
            ['cart' => 'required|json'],
            config('laracart.order_validation')
        ));

        if (config('laracart.models.user')) {
            $this->order->user_id = Auth::id();
        }

        // Insert validated values into db
        foreach ($validated as $key => $value) {
            if (Schema::hasColumn(config('laracart.tables.order'), $key)) {
                $this->order->{$key} = $value;
            }
        }

        $this->order->save();

        $cartItems = json_decode($validated['cart'], true);

        $this->saveProducts($cartItems);
    }

    protected function saveProducts($items)
    {
        $products = collect($items);

        // Create array of product IDs with quantity
        $products = $products->mapWithKeys(function ($item) {
            return [$item['id'] => ['quantity' => $item['quantity']]];
        });

        $this->order->products()->sync($products);
    }
}
