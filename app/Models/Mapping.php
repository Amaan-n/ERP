<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    protected $table = 'mappings';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function asset()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }

    public function tags()
    {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }
}
