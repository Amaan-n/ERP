<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetCategory extends Model
{
    use CreateAndUpdateTrait, SoftDeletes;

    protected $table = 'asset_categories';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
