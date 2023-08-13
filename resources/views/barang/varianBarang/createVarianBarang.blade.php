<x-layoutAdmin>

    <x-title>
        Tambah Varian Barang Baru {{ $barangMaster->nama_barang }}
    </x-title>

    <div class="m-5">
        <form method="POST" action="{{ route('storeVarianBarang') }}" enctype="multipart/form-data"
            class="flex flex-col gap-y-1">
            @csrf

            <input type="hidden" name="barang_master_id" value="{{ $barangMaster->id }}">

            <label for="nama" class="font-bold">Nama Barang</label>
            <input type="text" name="nama_varian_barang" class="p-1 border border-black" placeholder="Nama Barang"
                value="{{ old('nama_varian_barang') }}" />
            @error('nama_varian_barang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="harga_beli" class="font-bold">Harga Beli</label>
            <input type="text" name="harga_beli" class="p-1 border border-black" placeholder="15000"
                value="{{ old('harga_beli') }}" />
            @error('harga_beli')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="harga_jual" class="font-bold">Harga Jual</label>
            <input type="text" name="harga_jual" class="p-1 border border-black" placeholder="23000"
                value="{{ old('harga_jual') }}" />
            @error('harga_jual')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="kode_produk" class="font-bold">Kode Produk</label>
            <input type="text" name="kode_produk" class="p-1 border border-black" placeholder="Kode Produk"
                value="{{ old('kode_produk') }}" />
            @error('kode_produk')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="kategori" class="font-bold">Kategori</label>
            <select name="kategori_id" id="kategori" class="p-1 border border-black">
                <option value="">-pilih kategori-</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id }}">{{ $k->kategori }}</option>
                @endforeach
            </select>
            @error('kategori_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="deskripsi" class="font-bold">Deskripsi</label>
            <input type="text" name="deskripsi" class="p-1 border border-black" placeholder="Deskripsi"
                value="{{ old('deskripsi') }}" />
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="satuan" class="font-bold">Satuan</label>
            <select name="satuan_id" id="satuan" class="p-1 border border-black">
                <option value="">-pilih satuan-</option>
                @foreach ($satuan as $k)
                    <option value="{{ $k->id }}">{{ $k->satuan }}</option>
                @endforeach
            </select>
            @error('satuan_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="foto" class="font-bold">Foto Barang</label>
            <input type="file" name="foto_barang" class="p-1 border border-black" />
            @error('foto_barang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                Tambah Barang Baru
            </button>
        </form>
    </div>

</x-layoutAdmin>
