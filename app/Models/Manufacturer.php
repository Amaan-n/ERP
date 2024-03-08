<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use CreateAndUpdateTrait;

    protected $table = 'manufacturers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
