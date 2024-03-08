<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, CreateAndUpdateTrait;

    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
