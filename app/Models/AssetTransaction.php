<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetTransaction extends Model
{
    protected $table = 'asset_transactions';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function asset()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function added_by_user()
    {
        return $this->hasOne(User::class, 'id', 'added_by');
    }
}
