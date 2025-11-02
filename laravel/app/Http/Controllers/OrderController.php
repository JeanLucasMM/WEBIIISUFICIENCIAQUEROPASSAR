<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Listar todos os pedidos
    public function index(Request $request)
    {
        // Admin vê todos os pedidos, usuário comum só os seus
        $orders = $request->user()->role === 'admin'
            ? Order::with('items')->get()
            : $request->user()->orders()->with('items')->get();

        return response()->json($orders);
    }

    // Mostrar um pedido específico
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return response()->json($order->load('items'));
    }

    // Criar um novo pedido
    public function store(Request $request)
    {
        $this->authorize('create', Order::class);

        $request->validate([
            'total' => 'required|numeric',
            'status' => 'required|in:pending,paid,shipped,completed,canceled',
        ]);

        $order = Order::create([
            'user_id' => $request->user()->id,
            'total' => $request->total,
            'status' => $request->status,
        ]);

        return response()->json($order, 201);
    }

    // Atualizar um pedido
    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $request->validate([
            'total' => 'required|numeric',
            'status' => 'required|in:pending,paid,shipped,completed,canceled',
        ]);

        $order->update($request->only(['total', 'status']));
        return response()->json($order);
    }

    // Deletar um pedido (soft delete)
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }

    // Restaurar pedido (soft delete)
    public function restore($id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $this->authorize('restore', $order);

        $order->restore();
        return response()->json(['message' => 'Order restored', 'order' => $order]);
    }
}
