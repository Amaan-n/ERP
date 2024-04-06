<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AssetTransaction extends Model
{
    use LogsActivity;
    protected $table = 'asset_transactions';
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

    public function added_by_user()
    {
        return $this->hasOne(User::class, 'id', 'added_by');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
