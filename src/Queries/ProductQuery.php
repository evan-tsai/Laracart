<?php


namespace EvanTsai\Laracart\Queries;


class ProductQuery extends BaseQuery
{
    protected function className()
    {
        return config('laracart.classes.product', '\EvanTsai\Laracart\Product');
    }

    protected function appendQuery()
    {
        return $this->query;
    }
}
