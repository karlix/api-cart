<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public $incrementing = false;
    public $keyType = 'string';
    protected $fillable = ['id', 'price'];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
