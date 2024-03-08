<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldHasOption extends Model
{
    protected $table = 'field_has_options';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
