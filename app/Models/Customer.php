<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, CreateAndUpdateTrait;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
