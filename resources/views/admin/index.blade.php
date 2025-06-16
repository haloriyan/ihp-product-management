@extends('layouts.admin')

@section('title', "Products")
    
@section('content')
<div class="flex items-center gap-4">
    <div class="flex grow text-slate-700 gap-1">
        @if ($request->q != "" || $request->category != "")
            Menampilkan hasil
            @if ($request->q != "")
                pencarian untuk <span class="font-bold">"{{ $request->q }}"</span>
            @endif
            @if ($request->category != "")
                di kategori <span class="font-bold"> {{ $category->name }}</span>
            @endif
            .
            <a href="{{ route('admin.index') }}" class="text-primary underline">Bersihkan filter</a>
        @endif
    </div>
    <div class="border p-2 pb-0 rounded-lg  w-3/12">
        <div class="text-xs text-slate-500">Kategori :</div>
        <select name="category" class="outline-0 w-full h-12 text-sm" onchange="queryParam('category', this.value)">
            <option value="">Semua</option>
            @foreach ($categories as $category)
                <option {{ $request->category == $category->id ? "selected='selected'" : '' }} value="{{ $category->id }}">{{ $category->name }} ({{ $category->product_count }})</option>
            @endforeach
        </select>
    </div>
</div>

@if ($products->count() == 0)
    <div class="flex flex-col items-center gap-4 mt-10">
        <h3 class="text-xl text-slate-600">Belum ada data produk</h3>
        <a href="{{ route('product.create') }}" class="p-4 px-6 bg-primary text-white text-sm font-bold rounded-full">
            Tambahkan Produk
        </a>
    </div>
@endif

<div class="grid grid-cols-5 mobile:grid-cols-2 gap-6 mobile:gap-4 mt-8">
    @foreach ($products as $product)
        <div class="flex flex-col gap-1 group relative">
            @if ($product->image != null)
                <div class="relative">
                    <img src="{{ asset('storage/product_images/' . $product->image) }}" alt="{{ $product->name }}" class="w-full aspect-square rounded-lg object-cover bg-slate-100">
                    <div class="absolute bottom-0 left-0 p-4">
                        <a href="?category={{ $product->category_id }}" class="bg-primary text-xs text-white font-medium p-2 px-4 rounded-full">{{ Substring($product->category->name, 10) }}</a>
                    </div>
                </div>
            @endif
            <h3 class="text-lg text-slate-700 font-medium mt-3">{{ $product->name }}</h3>
            <div class="text-sm text-slate-500">
                {{ currency_encode($product->price) }}
            </div>

            <div class="absolute desktop:opacity-0 group-hover:opacity-100 top-4 mobile:top-2 right-4 mobile:right-2 flex items-center mobile:justify-end gap-2">
                <a href="{{ route('product.edit', $product->id) }}" class="cursor-pointer text-white text-xs font-bold bg-green-500 flex items-center gap-2 h-10 px-6 rounded-full mobile:hidden">
                    Edit
                </a>
                <a href="{{ route('product.edit', $product->id) }}" class="cursor-pointer text-xs text-white rounded-full bg-green-500 h-10 aspect-square flex items-center justify-center desktop:hidden">
                    <ion-icon name="create-outline" class="text-lg"></ion-icon>
                </a>
                <div class="cursor-pointer text-xs text-white rounded-full bg-red-500 h-10 aspect-square flex items-center justify-center" onclick="del({{ $product }})">
                    <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-10">
    {{ $products->links() }}
</div>
<div class="h-[100px]"></div>
@endsection

@section('toast')
@if ($message != "")
    <div class="bg-green-500 text-white p-3 px-4 rounded-lg flex items-center gap-4 toast">
        <div class="flex grow text-sm font-medium">{{ $message }}</div>
        <ion-icon name="close-outline" class="text-xl cursor-pointer" onclick="dismissToast(0)"></ion-icon>
    </div>
@endif
@endsection

@section('outer')
<a href="{{ route('product.create') }}" class="flex items-center justify-center h-14 aspect-square rounded-full bg-primary fixed bottom-12 right-10">
    <ion-icon name="add-outline" class="text-xl text-white"></ion-icon>
</a>

<div class="fixed top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-white/20 backdrop-blur-md hidden" id="DeleteModal">
    <form action="{{ route('product.delete') }}" method="POST" class="w-4/12 mobile:w-11/12 bg-white border p-8 rounded-lg flex flex-col gap-4">
        @csrf
        @method('DELETE')
        
        <input type="hidden" name="id" id="id">
        <div class="flex items-center gap-4">
            <h4 class="text-lg text-slate-700 flex grow">Hapus Produk</h4>
            <ion-icon name="close-outline" class="text-xl text-slate-700 cursor-pointer" onclick="toggleHidden('#DeleteModal')"></ion-icon>
        </div>

        <div class="text-sm text-slate-700">Yakin ingin menghapus produk <span id="name"></span>? Tindakan ini akan menghapus data secara permanen dan tidak dapat dipulihkan</div>

        <div class="border-t mt-4 pt-6 flex justify-end gap-4">
            <button class="p-3 px-6 rounded-full text-sm bg-slate-200" type="button" onclick="toggleHidden('#DeleteModal')">Batal</button>
            <button class="p-3 px-6 rounded-full text-sm bg-red-500 text-white font-medium">Hapus</button>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
    const del = data => {
        console.log(data);
        select("#DeleteModal #id").value = data.id;
        select("#DeleteModal #name").innerHTML = data.name;
        toggleHidden("#DeleteModal");
    }
</script>
@endsection