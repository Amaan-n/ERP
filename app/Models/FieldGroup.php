<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FieldGroup extends Model
{
    use CreateAndUpdateTrait,LogsActivity; 

    protected $table = 'field_groups';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function fields()
    {
        return $this->hasMany(FieldGroupHasField::class, 'field_group_id', 'id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
