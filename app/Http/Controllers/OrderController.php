<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Denomination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout(Denomination $denomination)
    {
        abort_unless($denomination->is_active && $denomination->product->is_active, 404);
        return view('orders.checkout', compact('denomination'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'denomination_id' => ['required','exists:denominations,id'],
            'player_id' => ['required','string','max:100'],
            'server_id' => ['nullable','string','max:100'],
            'payment_method' => ['required','in:bank_transfer,qris_manual'],
            'customer_note' => ['nullable','string','max:500'],
        ]);
        $denomination = Denomination::with('product')->findOrFail($data['denomination_id']);
        abort_unless($denomination->is_active && $denomination->product->is_active, 422);
        $order = Order::create([
            'user_id' => $request->user()->id,
            'denomination_id' => $denomination->id,
            'order_code' => 'SSS-' . now()->format('ymd') . '-' . Str::upper(Str::random(7)),
            'player_id' => $data['player_id'],
            'server_id' => $data['server_id'] ?? null,
            'customer_note' => $data['customer_note'] ?? null,
            'amount' => $denomination->price,
            'payment_method' => $data['payment_method'],
            'payment_status' => 'unpaid',
            'order_status' => 'pending_payment',
        ]);
        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat.');
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('denomination.product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($request->user()->id === $order->user_id || $request->user()->role === 'admin', 403);
        $order->load('denomination.product');
        return view('orders.show', compact('order'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        abort_unless($request->user()->id === $order->user_id, 403);
        abort_unless($order->payment_status === 'unpaid', 422);
        $data = $request->validate(['payment_proof' => ['required','image','mimes:jpg,jpeg,png,webp','max:2048']]);
        $path = $data['payment_proof']->store('payment-proofs', 'public');
        $order->update(['payment_proof' => $path, 'payment_status' => 'pending_verification']);
        return back()->with('success', 'Bukti pembayaran berhasil dikirim untuk diverifikasi.');
    }
}
