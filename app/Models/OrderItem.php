<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class OrderItem extends Model
{
    public $incrementing = false;
    public $keyType = 'string';
    protected $fillable = ['id', 'order_id', 'product_id', 'quantity'];

    public function product(): BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
