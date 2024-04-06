<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use HasFactory, CreateAndUpdateTrait, LogsActivity;

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function product_category()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'product_category_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
