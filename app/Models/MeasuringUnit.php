<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasuringUnit extends Model
{
    use HasFactory, CreateAndUpdateTrait;

    protected $table = 'measuring_units';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
