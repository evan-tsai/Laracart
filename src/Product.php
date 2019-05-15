<?php

namespace EvanTsai\Laracart;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('laracart.tables.product');
    }
}
