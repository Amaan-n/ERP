<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Configuration extends Model
{
    use LogsActivity;
    protected $table = 'configurations';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'added_by');
    }

    public function child_configurations()
    {
        return $this->hasMany(Configuration::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(Configuration::class, 'id', 'parent_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
