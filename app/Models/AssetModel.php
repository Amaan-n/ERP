<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AssetModel extends Model
{
    use CreateAndUpdateTrait, LogsActivity;

    protected $table = 'asset_models';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function manufacturer()
    {
        return $this->hasOne(Manufacturer::class, 'id', 'manufacturer_id');
    }

    public function asset_category()
    {
        return $this->hasOne(AssetCategory::class, 'id', 'asset_category_id');
    }

    public function field_group()
    {
        return $this->hasOne(FieldGroup::class, 'id', 'field_group_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'asset_model_id', 'id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
