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
    | Classes
    |--------------------------------------------------------------------------
    |
    | You can specify your own class, if using own Product class,
    | you should extend the package class. For User model,
    | set value to null if login is not required for
    | checkout.
    |
    */

    'classes' => [
        'product' => '\EvanTsai\Laracart\Product',
        'user' => 'App\Users',
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
