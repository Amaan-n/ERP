<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Asset extends Model
{
    use CreateAndUpdateTrait, SoftDeletes, LogsActivity;

    protected $table = 'assets';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function setPurchaseDateAttribute($value)
    {
        $this->attributes['purchase_date'] = !empty($value) ? Carbon::createFromTimestamp(strtotime($value))->format('Y-m-d') : null;
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function asset_model()
    {
        return $this->hasOne(AssetModel::class, 'id', 'asset_model_id');
    }

    public function asset_category()
    {
        return $this->hasOne(AssetCategory::class, 'id', 'category_id');
    }

    public function parameters()
    {
        return $this->hasMany(AssetHasParameter::class, 'asset_id', 'id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
