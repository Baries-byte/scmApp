<x-layoutAdmin>

    <x-title>
        Ubah Data Barang
    </x-title>

    <div class="m-5">
        <form method="POST" action="{{ route('updateBarangSupplier', ['barangSupplier' => $barangSupplier->id]) }}"
            class="flex flex-col gap-y-1" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label class="font-bold">Nama Barang</label>
            <input type="text" name="nama_barang" class="p-1 border border-black" placeholder="Nama Barang"
                value="{{ $barangSupplier->nama_barang }}" />
            @error('nama_barang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label class="font-bold">Kode Barang</label>
            <input type="text" name="kode_barang" class="p-1 border border-black" placeholder="Kode Barang"
                value="{{ $barangSupplier->kode_barang }}" />
            @error('kode_barang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label class="font-bold">Merek</label>
            <input type="text" name="merek" class="p-1 border border-black" placeholder="Merek"
                value="{{ $barangSupplier->merek }}" />
            @error('merek')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="harga_jual" class="font-bold">Harga Jual</label>
            <input type="text" name="harga_jual" class="p-1 border border-black"
                placeholder="Angka Tanpa Titik maupun Koma" value="{{ $barangSupplier->harga_jual }}" />
            @error('harga_jual')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="deskripsi" class="font-bold">Deskripsi</label>
            <input type="text" name="deskripsi" class="p-1 border border-black" placeholder="Deskripsi"
                value="{{ $barangSupplier->deskripsi }}" />
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="foto" class="font-bold">Foto Barang</label>
            <input type="file" name="foto_barang" class="p-1 border border-black" />
            <img src="{{ asset('storage/' . $barangSupplier->foto) }}" alt="Foto Barang" width="200px" height="200px">
            @error('foto_barang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <input type="hidden" name="supplier_id" value="{{ auth()->user()->supplier->id }}">

            <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                Ubah Data Barang
            </button>
        </form>
    </div>

</x-layoutAdmin>
