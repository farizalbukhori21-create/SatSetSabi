@extends('layouts.app')
@section('title','Riwayat Pesanan')
@section('content')
<h1 class="mb-6 text-3xl font-black">Riwayat Pesanan</h1>
<div class="space-y-3">@forelse($orders as $order)
<a href="{{ route('orders.show',$order) }}" class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-900 p-4"><div><p class="font-bold">{{ $order->denomination->product->name }} · {{ $order->denomination->name }}</p><p class="text-xs text-slate-500">{{ $order->order_code }}</p></div><div class="text-right"><p class="font-bold text-yellow-300">Rp {{ number_format($order->amount,0,',','.') }}</p><p class="text-xs text-slate-400">{{ $order->order_status }} / {{ $order->payment_status }}</p></div></a>
@empty <p class="text-slate-400">Belum ada pesanan.</p> @endforelse</div><div class="mt-5">{{ $orders->links() }}</div>
@endsection
