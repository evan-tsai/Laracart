<?php


namespace EvanTsai\Laracart\Queries;


class ProductQuery extends BaseQuery
{
    protected function className()
    {
        return config('laracart.models.product');
    }

    protected function appendQuery()
    {
        return $this->query;
    }
}
