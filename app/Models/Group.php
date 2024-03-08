<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use CreateAndUpdateTrait;

    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function accesses()
    {
        return $this->hasMany(GroupHasAccess::class, 'group_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'group_id', 'id');
    }
}
