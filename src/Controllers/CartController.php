<?php

namespace EvanTsai\Laracart\Controllers;

use App\Http\Controllers\Controller;
use EvanTsai\Laracart\Modules\OrderModule;
use EvanTsai\Laracart\Queries\ProductQuery;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class CartController extends Controller
{
    public function getProducts(ProductQuery $query)
    {
        return response()->json($query->get());
    }

    public function findProduct($id, ProductQuery $query)
    {
        $product = $query->find($id);

        return response()->json($product);
    }

    public function createOrder(Request $request, OrderModule $orderModule)
    {
        $orderModule->placeOrder($request);

        if (config('laracart.check_out_immediately')) {
            $html = $orderModule->checkout($request);

            return response()->json(['html' => $html]);
        }

        return response()->json(['redirect' => route('test')]);
    }

    public function checkout($id, Request $request, OrderModule $orderModule)
    {
        $orderModule->for($id)->checkout($request);
    }

    public function callback()
    {

    }
}
