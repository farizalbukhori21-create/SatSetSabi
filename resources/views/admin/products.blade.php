@extends('layouts.app')
@section('title','Produk')
@section('content')
<h1 class="mb-6 text-3xl font-black">Produk & Nominal</h1>
<form method="POST" action="{{ route('admin.products.store') }}" class="mb-6 grid gap-3 rounded-xl bg-slate-900 p-4 sm:grid-cols-3">@csrf<select name="category_id" required class="rounded-lg bg-slate-950 p-3">@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select><input name="name" required placeholder="Nama game" class="rounded-lg bg-slate-950 p-3"><input name="description" placeholder="Deskripsi" class="rounded-lg bg-slate-950 p-3"><button class="rounded-lg bg-yellow-400 p-3 font-bold text-slate-950 sm:col-span-3">Tambah Game</button></form>
<form method="POST" action="{{ route('admin.denominations.store') }}" class="mb-8 grid gap-3 rounded-xl bg-slate-900 p-4 sm:grid-cols-3">@csrf<select name="product_id" required class="rounded-lg bg-slate-950 p-3">@foreach($products as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select><input name="name" required placeholder="Contoh: 86 Diamonds" class="rounded-lg bg-slate-950 p-3"><input name="price" type="number" min="1" required placeholder="Harga (rupiah)" class="rounded-lg bg-slate-950 p-3"><button class="rounded-lg bg-blue-600 p-3 font-bold sm:col-span-3">Tambah Nominal</button></form>
<div class="space-y-2">@foreach($products as $p)<div class="rounded-lg border border-slate-800 bg-slate-900 p-4"><b>{{ $p->name }}</b><p class="text-sm text-slate-400">{{ $p->category->name }}</p></div>@endforeach</div>
@endsection
