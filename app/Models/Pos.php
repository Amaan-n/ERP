<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    use CreateAndUpdateTrait;

    protected $table = 'pos';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    const DISCOUNT = ['flat', 'percentage'];
    const STATUSES = ['booked', 'canceled', 'completed'];
    const PAYMENT_STATUSES = ['pending', 'advance_captured', 'captured'];
    const CREATED_FROM = ['pos', 'admin'];

//    public function customer()
//    {
//        return $this->hasOne(Customer::class, 'id', 'customer_id');
//    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updated_by_user()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function transactions()
    {
        return $this->hasMany(PosHasTransaction::class, 'pos_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(PosHasProduct::class, 'pos_id', 'id');
    }
}
