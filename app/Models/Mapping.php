<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Mapping extends Model
{
    use LogsActivity;
    protected $table = 'mappings';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function asset()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }

    public function tags()
    {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
