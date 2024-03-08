<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;

class FieldGroup extends Model
{
    use CreateAndUpdateTrait;

    protected $table = 'field_groups';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function fields()
    {
        return $this->hasMany(FieldGroupHasField::class, 'field_group_id', 'id');
    }
}
