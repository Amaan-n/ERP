<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    const PROVIDERS = ['MERAK'];

    const TYPES = [
        'QR Code' => 'QR Code'
    ];

    public function mapping()
    {
        return $this->hasOne(Mapping::class, 'tag_id', 'id');
    }
}
