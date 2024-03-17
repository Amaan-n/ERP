<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosHasProduct extends Model
{
    protected $table = 'pos_has_products';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function pos()
    {
        return $this->hasOne(Pos::class, 'id', 'pos_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
