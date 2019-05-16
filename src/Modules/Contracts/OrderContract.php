<?php


namespace EvanTsai\Laracart\Modules\Contracts;


use Illuminate\Http\Request;

interface OrderContract
{
    public function placeOrder(Request $request);

    public function checkout(Request $request);
}
