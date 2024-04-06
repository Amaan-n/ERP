<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Allocation extends Model
{
    use LogsActivity;
    protected $table = 'allocations';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function asset()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function allocated_by()
    {
        return $this->hasOne(User::class, 'id', 'allocated_by');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
