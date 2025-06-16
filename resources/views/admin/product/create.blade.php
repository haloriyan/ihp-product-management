@extends('layouts.admin')

@section('title', 'Tambah Produk')
    
@section('content')
<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="flex items-center gap-6 mobile:gap-4">
        <a href="{{ route('admin.index') }}" class="flex items-center gap-4">
            <ion-icon name="arrow-back-outline" class="text-xl text-slate-700"></ion-icon>
            <div class="mobile:hidden text-xs text-slate-500">kembali</div>
        </a>
        <div class="desktop:hidden text-lg text-slate-700 font-medium">Tambah Produk</div>
        <div class="flex grow"></div>
        <button class="bg-green-500 text-white text-sm mobile:text-xs font-bold rounded-full p-3 px-6">
            Tambahkan
        </button>
    </div>

    <div class="flex mobile:flex-col items-start gap-10 mobile:gap-6 mt-10">
        <div id="image_area" class="bg-slate-300 rounded-xl w-96 mobile:w-full aspect-square relative flex flex-col gap-4 items-center justify-center">
            <ion-icon name="image-outline" class="text-5xl text-slate-700"></ion-icon>
            <div class="text-xs text-slate-600 text-center">Drop Gambar<br />atau Klik untuk Memilih</div>
            <input type="file" name="image" id="image" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#image_area')" required>
        </div>
        <div class="flex flex-col gap-4 grow mobile:w-full">
            <div class="group border border-slate-300 focus-within:border-blue-500 rounded-lg p-1 relative px-3">
                <label class="text-slate-500 group-focus-within:text-blue-500 text-xs absolute top-2 left-3">Nama Produk</label>
                <input type="text" name="name" id="name" class="w-full outline-0 h-12 text-sm bg-transparent mt-3" required />
            </div>

            <div class="border border-slate-300 p-3 rounded-lg">
                <div class="text-xs text-slate-500">Kategori</div>
                <select name="category" class="w-full outline-0 h-12 text-sm" required>
                    <option value="">Pilih...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="group border border-slate-300 focus-within:border-blue-500 rounded-lg p-1 relative px-3 flex items-center gap-4">
                <label class="text-slate-500 group-focus-within:text-blue-500 text-xs absolute top-2 left-3">Stok</label>
                <input type="number" value="5" min="1" name="stock" id="stock" class="w-full outline-0 h-12 text-sm bg-transparent mt-3" required />
                <button type="button" class="bg-slate-300 rounded-lg p-2 px-4 text-slate-700" onclick="changeQty('decrease')">
                    <ion-icon name="remove-outline"></ion-icon>
                </button>
                <button type="button" class="bg-slate-300 rounded-lg p-2 px-4 text-slate-700" onclick="changeQty('increase')">
                    <ion-icon name="add-outline"></ion-icon>
                </button>
            </div>

            <div class="group border border-slate-300 focus-within:border-blue-500 rounded-lg p-1 relative px-3">
                <label class="text-slate-500 group-focus-within:text-blue-500 text-xs absolute top-2 left-3">Harga</label>
                <input type="text" name="price" id="price" class="w-full outline-0 h-12 text-sm bg-transparent mt-3" oninput="typePrice(this)" value="{{ currency_encode(0) }}" required />
            </div>
        </div>
    </div>
</form>
@endsection

@section('toast')
@if ($errors->count() > 0)
    @foreach ($errors->all() as $e => $err)
        <div class="bg-red-500 text-white p-3 px-4 rounded-lg flex items-center gap-4 toast">
            <div class="flex grow text-sm font-medium">{{ $err }}</div>
            <ion-icon name="close-outline" class="text-xl cursor-pointer" onclick="dismissToast($e)"></ion-icon>
        </div>
    @endforeach
@endif
@endsection

@section('javascript')
<script>
    const changeQty = (action) => {
        let input = select("input#stock");
        let currentQuantity = parseInt(input.value);
        if (action === "increase") {
            if (currentQuantity % 10 !== 0) {
                currentQuantity = Math.ceil(currentQuantity / 10) * 10;
            } else {
                currentQuantity += 10;
            }
        } else {
            if (currentQuantity % 10 !== 0) {
                currentQuantity = Math.floor(currentQuantity / 10) * 10;
            } else {
                if (currentQuantity > 10) {
                    currentQuantity -= 10;
                } else {
                    currentQuantity = 1;
                }
            }
        }
        input.value = currentQuantity;
    }
    const typePrice = input => {
        let val = Currency(input.value).decode();
        if (isNaN(val)) {
            val = 0;
        }
        input.value = Currency(val).encode();
    }
</script>
@endsection