<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Attachment extends Model
{
    use HasFactory, CreateAndUpdateTrait, LogsActivity;

    protected $table = 'attachments';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()->logOnlyDirty();
    }
}
