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
        $order = $orderModule->placeOrder($request)->getModel();

        $routeName = config('laracart.order_review_route');

        if (!$routeName) {
            $result = $orderModule->checkout($request);

            return response()->json($result);
        }

        return response()->json(['redirect' => route($routeName, ['order' => $order->id])]);
    }

    public function checkout($id, Request $request, OrderModule $orderModule)
    {
        $orderModule->for($id)->checkout($request);
    }

    public function callback($id, Request $request, OrderModule $orderModule)
    {
        $result = $orderModule->processOrder($id, $request);

        return response()->json($result);
    }
}
