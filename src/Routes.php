<?php


namespace EvanTsai\Laracart;


class Routes
{
    public static function get()
    {
        $router = app('router');

        $controller = config('laracart.controller', '\EvanTsai\Laracart\Controllers\CartController');

        $router->group([
            'prefix' => 'laracart',
            'as' => 'laracart.',
        ], function () use ($router, $controller) {
            $router->get('product', ['uses' => "$controller@getProducts", 'as' => 'products']);
        });
    }
}
