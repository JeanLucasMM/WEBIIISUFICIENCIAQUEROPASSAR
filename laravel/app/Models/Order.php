<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// IMPORTS de outros models que usamos
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];

    // 🔹 Um pedido pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔹 Um pedido tem vários itens
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
