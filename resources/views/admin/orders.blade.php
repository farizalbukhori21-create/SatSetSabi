@extends('layouts.app')
@section('title','Kelola Pesanan')
@section('content')
<h1 class="mb-6 text-3xl font-black">Kelola Pesanan</h1>
<div class="space-y-4">@foreach($orders as $order)
<div class="rounded-xl border border-slate-800 bg-slate-900 p-5"><div class="flex flex-wrap justify-between gap-3"><div><b>{{ $order->order_code }}</b><p class="text-sm text-slate-400">{{ $order->user->name }} · {{ $order->denomination->product->name }} · {{ $order->denomination->name }}</p><p class="mt-1 text-yellow-300">Rp {{ number_format($order->amount,0,',','.') }}</p>@if($order->payment_proof)<a class="text-sm text-blue-300 underline" target="_blank" href="{{ asset('storage/'.$order->payment_proof) }}">Lihat bukti bayar</a>@endif</div>
<form method="POST" action="{{ route('admin.orders.status',$order) }}" class="flex flex-wrap items-end gap-2">@csrf @method('PATCH')
<label class="text-xs text-slate-400">Pembayaran<select name="payment_status" class="mt-1 block rounded-lg bg-slate-950 p-2 text-sm">@foreach(['unpaid','pending_verification','paid','rejected'] as $s)<option @selected($order->payment_status===$s) value="{{ $s }}">{{ $s }}</option>@endforeach</select></label>
<label class="text-xs text-slate-400">Pesanan<select name="order_status" class="mt-1 block rounded-lg bg-slate-950 p-2 text-sm">@foreach(['pending_payment','processing','completed','failed','cancelled'] as $s)<option @selected($order->order_status===$s) value="{{ $s }}">{{ $s }}</option>@endforeach</select></label>
<button class="rounded-lg bg-yellow-400 px-4 py-2 text-sm font-bold text-slate-950">Simpan</button></form></div></div>
@endforeach<div>{{ $orders->links() }}</div></div>
@endsection
