@extends('layouts.app')
@section('title','Checkout')
@section('content')
<div class="mx-auto max-w-2xl"><a href="{{ route('games.show',$denomination->product) }}" class="text-sm text-blue-300">← Kembali</a><h1 class="mt-4 text-3xl font-black">Checkout</h1>
<div class="my-5 rounded-xl border border-slate-800 bg-slate-900 p-5"><p class="text-slate-400">{{ $denomination->product->name }}</p><h2 class="text-xl font-bold">{{ $denomination->name }}</h2><p class="mt-2 text-2xl font-black text-yellow-300">Rp {{ number_format($denomination->price,0,',','.') }}</p></div>
<form method="POST" action="{{ route('orders.store') }}" class="space-y-4 rounded-xl border border-slate-800 bg-slate-900 p-5">@csrf<input type="hidden" name="denomination_id" value="{{ $denomination->id }}">
<label class="block text-sm">Player ID<input name="player_id" required class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-950 p-3" placeholder="Masukkan Player ID"></label>
<label class="block text-sm">Server ID (jika diperlukan)<input name="server_id" class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-950 p-3" placeholder="Masukkan Server ID"></label>
<label class="block text-sm">Metode pembayaran<select name="payment_method" required class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-950 p-3"><option value="bank_transfer">Transfer bank manual</option><option value="qris_manual">QRIS manual</option></select></label>
<label class="block text-sm">Catatan (opsional)<textarea name="customer_note" class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-950 p-3"></textarea></label>
<p class="text-xs text-slate-400">Pembayaran pada versi MVP diverifikasi admin secara manual. Pastikan ID pemain benar.</p>
<button class="w-full rounded-lg bg-yellow-400 p-3 font-black text-slate-950">Buat Pesanan</button></form></div>
@endsection
