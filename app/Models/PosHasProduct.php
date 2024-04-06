<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PosHasProduct extends Model
{
    use LogsActivity;
    protected $table = 'pos_has_products';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function pos()
    {
        return $this->hasOne(Pos::class, 'id', 'pos_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
