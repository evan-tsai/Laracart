<?php


namespace EvanTsai\Laracart\Queries;


abstract class BaseQuery
{
    protected $query;

    public function __construct()
    {
        $this->query = $this->className()::query();
    }

    public function get()
    {
        return $this->appendQuery()->get();
    }

    abstract protected function className();
    abstract protected function appendQuery();
}
