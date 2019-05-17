<?php

namespace EvanTsai\Laracart\Controllers;

use App\Http\Controllers\Controller;
use EvanTsai\Laracart\Modules\OrderModule;
use EvanTsai\Laracart\Modules\ProductModule;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function getProducts(ProductModule $productModule)
    {
        $products = $productModule->query()->get();

        return response()->json($products);
    }

    public function findProduct($id, ProductModule $productModule)
    {
        $product = $productModule->for($id)->getModel();

        return response()->json($product);
    }

    public function createOrder(Request $request, OrderModule $orderModule)
    {
        $orderModule->placeOrder($request);

        if (config('laracart.check_out_immediately')) {
            $result = $orderModule->checkout($request);

            return response()->json($result);
        }

        return response()->json(['redirect' => route('test')]);
    }

    public function checkout($id, Request $request, OrderModule $orderModule)
    {
        $orderModule->for($id)->checkout($request);
    }

    public function callback(Request $request, OrderModule $orderModule)
    {
        $result = $orderModule->processOrder($request);

        return response()->json($result);
    }

    protected function getProductQuery()
    {

    }
}
