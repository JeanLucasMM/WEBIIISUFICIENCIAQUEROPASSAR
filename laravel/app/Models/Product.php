<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// IMPORTS de outros models que usamos
use App\Models\Category;
use App\Models\OrderItem;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
    ];

    // 🔹 Cada produto pertence a uma categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 🔹 Cada produto pode aparecer em vários itens de pedido
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
