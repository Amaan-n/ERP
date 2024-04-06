<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Tag extends Model
{
    use LogsActivity;
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
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
