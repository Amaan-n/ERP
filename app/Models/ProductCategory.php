<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory, CreateAndUpdateTrait;

    protected $table = 'product_categories';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
