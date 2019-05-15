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
];
