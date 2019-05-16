<?php


namespace EvanTsai\Laracart;


class Routes
{
    public static function get()
    {
        $router = app('router');

        $controller = config('laracart.controller', '\EvanTsai\Laracart\Controllers\CartController');

        $router->group([
            'prefix' => config('laracart.route_prefix'),
            'as' => 'laracart.',
        ], function () use ($router, $controller) {
            $router->get('product', ['uses' => "$controller@getProducts", 'as' => 'product.get']);
            $router->get('product/{id}', ['uses' => "$controller@findProduct", 'as' => 'product.find']);
            $router->post('order', ['uses' => "$controller@createOrder", 'as' => 'order.create']);
            $router->post('checkout', ['uses' => "$controller@checkout", 'as' => 'checkout']);
            $router->post('callback', ['uses' => "$controller@callback", 'as' => 'callback']);
        });
    }
}
