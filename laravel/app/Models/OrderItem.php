<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// IMPORTS de outros models que usamos
use App\Models\Order;
use App\Models\Product;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // 🔹 Um item pertence a um pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // 🔹 Um item pertence a um produto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
