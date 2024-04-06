<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;  
use Spatie\Activitylog\Traits\LogsActivity;

class Group extends Model
{
    use CreateAndUpdateTrait , LogsActivity;

    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function accesses()
    {
        return $this->hasMany(GroupHasAccess::class, 'group_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'group_id', 'id');
    }
    public function getActivitylogOptions(): LogOptions
    { 
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
