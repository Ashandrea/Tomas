<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrderItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'order_id',
        'food_id',
        'quantity',
        'price_at_time',
        'notes',
    ];


    protected $casts = [
        'price_at_time' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
} 