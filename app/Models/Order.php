<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'email', 'name', 'last_name', 'document', 'country_code', 'state_code',

        'postal_code', 'city', 'address', 'complement', 'phone', 'total', 'status'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
