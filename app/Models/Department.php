<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use CreateAndUpdateTrait;

    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
