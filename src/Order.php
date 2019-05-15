<?php

namespace EvanTsai\Laracart;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_CREATED = 1;
    const STATUS_PENDING = 2;
    const STATUS_PAID = 3;
    const STATUS_SHIPPING = 4;
    const STATUS_COMPLETED = 5;
    const STATUS_FAILED = 6;
    const STATUS_CANCELLED = 7;

    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('laracart.tables.order');
    }
}
