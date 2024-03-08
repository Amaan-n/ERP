<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use CreateAndUpdateTrait;

    protected $table = 'fields';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    const ELEMENTS = ['text', 'textarea', 'select', 'radio', 'checkbox'];

    public function options()
    {
        return $this->hasMany(FieldHasOption::class, 'field_id', 'id');
    }
}
