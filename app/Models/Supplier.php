<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use CreateAndUpdateTrait;

    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
