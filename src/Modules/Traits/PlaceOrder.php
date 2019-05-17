<?php


namespace EvanTsai\Laracart\Modules\Traits;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait PlaceOrder
{
    public function placeOrder(Request $request)
    {
        $validated = $this->validate($request);

        $this->appendValues($validated);
        $this->model->save();

        $cartItems = json_decode($validated['cart'], true);
        $this->saveProducts($cartItems);

        return $this;
    }

    protected function calculateNextId()
    {
        $yearMonth = Carbon::now()->format('Ym');
        $idPrefix = strtoupper(sprintf('%s%06d', config('laracart.order_prefix'), $yearMonth));

        $maxId = call_user_func($this->getModelClass() . '::max', 'id');

        $max = intval(str_replace($idPrefix, '', $maxId));

        return $idPrefix . sprintf('%05d', $max + 1);
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
        $this->model->id = $this->calculateNextId();

        if (config('laracart.models.user')) {
            $this->model->user_id = Auth::id();
        }

        foreach ($data as $key => $value) {
            if (Schema::hasColumn(config('laracart.tables.order'), $key)) {
                $this->model->{$key} = $value;
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

        $this->model->products()->sync($products);
    }
}
