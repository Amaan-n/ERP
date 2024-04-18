<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateAndUpdateTrait;

class Holiday extends Model
{
    use HasFactory,CreateAndUpdateTrait;
}
