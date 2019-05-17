<?php


namespace EvanTsai\Laracart\Modules;


class ProductModule extends BaseModule
{
    protected function getModelClass()
    {
        return config('laracart.models.product');
    }
}
