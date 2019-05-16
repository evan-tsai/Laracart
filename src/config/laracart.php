<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Controller
    |--------------------------------------------------------------------------
    |
    | You can specify your own controller,
    | just remember to extend the original one.
    |
    */
    'controller' => '\EvanTsai\Laracart\Controllers\CartController',

    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | You can customize prefix to Laracart's routes
    |
    */
    'route_prefix' => 'laracart',

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | You can specify your own classes. For User model,
    | set value to null if login is not required for
    | checkout.
    |
    */

    'models' => [
        'product' => 'App\Product',
        'order' => 'App\Order',
        'user' => 'App\Users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    |
    | You can specify your table names.
    |
    */

    'tables' => [
        'product' => 'products',
        'order' => 'orders',
    ],

    /*
    |--------------------------------------------------------------------------
    | Order Validation
    |--------------------------------------------------------------------------
    |
    | Specify validation for creating a new order.
    | Make sure key matches database field
    | and form input names.
    |
    */

    'order_validation' => [
        'name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
        'address' => 'nullable|string',
    ],

    /*
   |--------------------------------------------------------------------------
   | Payment Gateways
   |--------------------------------------------------------------------------
   |
   | List of payment gateways, can add own gateways
   |
   */

    'gateways' => [
        'ecpay' => [
            'class' => \EvanTsai\Laracart\Gateways\ECPayGateway::class,
            'api_url' => 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5',
            'merchant_id' => env('ECPAY_MERCHANT_ID'),
            'hash_key' => env('ECPAY_HASH_KEY'),
            'hash_iv' => env('ECPAY_HASH_IV'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Available Gateways
    |--------------------------------------------------------------------------
    |
    | List of payment gateways available to user
    |
    */

    'available_gateways' => [
        'ecpay'
    ],

    /*
     |--------------------------------------------------------------------------
     | Gatewall payment callback
     |--------------------------------------------------------------------------
     |
     | Which route to call for gateway callbacks.
     |
     */

    'callback_route' => 'laracart.callback',

    /*
    |--------------------------------------------------------------------------
    | Redirect route after callback
    |--------------------------------------------------------------------------
    |
    | Which route to call after the callback has been processed.
    |
    */

    'callback_redirect_route' => '/',

];
