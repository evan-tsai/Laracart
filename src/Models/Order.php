<?php

namespace EvanTsai\Laracart\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_FAILED = 3;
    const STATUS_CANCELLED = 4;

    protected $table;

    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('laracart.tables.order');
    }

    public function products()
    {
        $tableName = config('laracart.tables.order') . '_' . config('laracart.tables.product');

        return $this->belongsToMany(config('laracart.models.product'), $tableName)->withPivot('quantity');
    }

    public function user()
    {
        return $this->belongsTo(config('laracart.models.user'), 'user_id');
    }

    public static function getStatusLabels()
    {
        return collect([
            self::STATUS_PENDING => 'Pending',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_CANCELLED => 'Cancelled',
        ]);
    }
}
