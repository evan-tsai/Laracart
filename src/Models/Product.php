<?php

namespace EvanTsai\Laracart\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table;

    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('laracart.tables.product');
    }
}
