<?php

namespace EvanTsai\Laracart\Controllers;

use App\Http\Controllers\Controller;
use EvanTsai\Laracart\Modules\OrderModule;
use EvanTsai\Laracart\Queries\ProductQuery;
use Illuminate\Http\Request;


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

        return response()->json([
            'redirect' => route('test'),
        ]);
    }
}
