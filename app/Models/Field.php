<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Field extends Model
{
    use CreateAndUpdateTrait,LogsActivity;

    protected $table = 'fields';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    const ELEMENTS = ['text', 'textarea', 'select', 'radio', 'checkbox'];

    public function options()
    {
        return $this->hasMany(FieldHasOption::class, 'field_id', 'id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
