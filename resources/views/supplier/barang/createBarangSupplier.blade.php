<x-layoutAdmin>

    <x-title>
        Tambah Barang Baru
    </x-title>

    <div class="m-5">
        <form method="POST" action="{{ route('storeBarangSupplier') }}" class="flex flex-col gap-y-1"
            enctype="multipart/form-data">

            @csrf
            <label class="font-bold">Nama Barang</label>
            <input type="text" name="nama_barang" class="p-1 border border-black" placeholder="Nama Barang" />
            @error('nama_barang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label class="font-bold">Kode Barang</label>
            <input type="text" name="kode_barang" class="p-1 border border-black" placeholder="Kode Barang" />
            @error('kode_barang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label class="font-bold">Merek</label>
            <input type="text" name="merek" class="p-1 border border-black" placeholder="Merek" />
            @error('merek')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="harga_jual" class="font-bold">Harga Jual</label>
            <input type="text" name="harga_jual" class="p-1 border border-black"
                placeholder="Angka Tanpa Titik maupun Koma" />
            @error('harga_jual')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            
            <label for="deskripsi" class="font-bold">Deskripsi</label>
            <input type="text" name="deskripsi" class="p-1 border border-black" placeholder="Deskripsi" />
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="foto" class="font-bold">Foto Barang</label>
            <input type="file" name="foto_barang" class="p-1 border border-black" />
            @error('foto_barang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <input type="hidden" name="supplier_id" value="{{ auth()->user()->supplier->id }}">

            <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                Tambah Barang Baru
            </button>
        </form>
    </div>

</x-layoutAdmin>
