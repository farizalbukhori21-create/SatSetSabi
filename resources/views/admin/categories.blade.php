@extends('layouts.app')
@section('title','Kategori')
@section('content')
<h1 class="mb-6 text-3xl font-black">Kategori Game</h1>
<form method="POST" action="{{ route('admin.categories.store') }}" class="mb-6 flex flex-wrap gap-2 rounded-xl bg-slate-900 p-4">@csrf<input name="name" required placeholder="Nama kategori" class="rounded-lg bg-slate-950 p-3"><input name="description" placeholder="Deskripsi" class="min-w-60 flex-1 rounded-lg bg-slate-950 p-3"><button class="rounded-lg bg-yellow-400 px-5 font-bold text-slate-950">Tambah</button></form>
<div class="space-y-2">@foreach($categories as $category)<div class="rounded-lg border border-slate-800 bg-slate-900 p-4"><b>{{ $category->name }}</b><p class="text-sm text-slate-400">{{ $category->description }}</p></div>@endforeach</div>
@endsection
