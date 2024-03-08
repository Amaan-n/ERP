<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetHasParameter extends Model
{
    protected $table = 'asset_has_parameters';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
