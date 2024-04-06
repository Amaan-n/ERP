<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FieldGroupHasField extends Model
{
    use LogsActivity;
    protected $table = 'field_group_has_fields';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function field()
    {
        return $this->hasOne(Field::class, 'id', 'field_id');
    }

    public function field_group()
    {
        return $this->hasOne(FieldGroup::class, 'id', 'field_group_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
