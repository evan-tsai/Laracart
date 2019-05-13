<?php

namespace EvanTsai\Laracart\Controllers;

use App\Http\Controllers\Controller;
use EvanTsai\Laracart\Queries\ProductQuery;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getProducts(ProductQuery $query)
    {
        return response()->json($query->get());
    }
}
