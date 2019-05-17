<?php

namespace EvanTsai\Laracart\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_CREATED = 1;
    const STATUS_PENDING = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_FAILED = 4;
    const STATUS_CANCELLED = 5;

    public $incrementing = false;

    protected $keyType = 'string';

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
            self::STATUS_CREATED => 'Created',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_CANCELLED => 'Cancelled',
        ]);
    }
}
