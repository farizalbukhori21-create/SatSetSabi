@extends('layouts.app')
@section('title','Detail Pesanan')
@section('content')
<div class="mx-auto max-w-2xl"><h1 class="text-3xl font-black">Detail Pesanan</h1><div class="mt-5 space-y-3 rounded-2xl border border-slate-800 bg-slate-900 p-6">
<div class="flex justify-between gap-3"><span class="text-slate-400">Kode</span><b>{{ $order->order_code }}</b></div><div class="flex justify-between gap-3"><span class="text-slate-400">Game</span><b>{{ $order->denomination->product->name }}</b></div><div class="flex justify-between gap-3"><span class="text-slate-400">Nominal</span><b>{{ $order->denomination->name }}</b></div><div class="flex justify-between gap-3"><span class="text-slate-400">Player ID</span><b>{{ $order->player_id }}</b></div><div class="flex justify-between gap-3"><span class="text-slate-400">Total</span><b class="text-yellow-300">Rp {{ number_format($order->amount,0,',','.') }}</b></div><div class="flex justify-between gap-3"><span class="text-slate-400">Pembayaran</span><b>{{ $order->payment_status }}</b></div><div class="flex justify-between gap-3"><span class="text-slate-400">Pesanan</span><b>{{ $order->order_status }}</b></div>
@if($order->payment_status === 'unpaid')
<div class="border-t border-slate-700 pt-5"><h2 class="mb-2 font-bold">Kirim bukti pembayaran</h2><p class="mb-3 text-sm text-slate-400">Transfer ke rekening/QRIS resmi yang diinformasikan admin, lalu unggah bukti. Detail rekening belum dikonfigurasi di MVP ini.</p><form method="POST" enctype="multipart/form-data" action="{{ route('orders.proof',$order) }}">@csrf<input type="file" name="payment_proof" accept="image/*" required class="block w-full text-sm"><button class="mt-3 rounded-lg bg-yellow-400 px-5 py-2 font-bold text-slate-950">Upload Bukti</button></form></div>
@elseif($order->payment_proof)
<p class="text-sm text-slate-400">Bukti pembayaran sudah dikirim untuk verifikasi.</p>
@endif
</div></div>
@endsection
