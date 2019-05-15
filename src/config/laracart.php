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
        'user' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Request
    |--------------------------------------------------------------------------
    |
    | When sending your form to the backend, you can set
    | which fields you want to exclude. By default,
    | the backend will accept all fields and
    | insert them into the database.
    |
    */

    'request' => [
        'except' => [],
    ],
];
