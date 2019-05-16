<?php


namespace EvanTsai\Laracart\Modules\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait PlaceOrder
{
    public function placeOrder(Request $request)
    {
        $validated = $this->validate($request);

        $this->appendValues($validated);
        $this->order->save();

        $cartItems = json_decode($validated['cart'], true);
        $this->saveProducts($cartItems);

        return $this;
    }

    protected function validate($request)
    {
        return $request->validate(array_merge(
            ['cart' => 'required|json'],
            config('laracart.order_validation')
        ));
    }

    protected function appendValues($data)
    {
        if (config('laracart.models.user')) {
            $this->order->user_id = Auth::id();
        }

        foreach ($data as $key => $value) {
            if (Schema::hasColumn(config('laracart.tables.order'), $key)) {
                $this->order->{$key} = $value;
            }
        }
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