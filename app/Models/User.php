<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, CreateAndUpdateTrait, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime',];

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id', 'id');
    }
}
