<x-layoutAdmin>

    <x-title>
        Tambah Barang Master Baru
    </x-title>

    <div class="m-5">
        <form method="POST" action="{{ route('storeBarangMaster') }}" enctype="multipart/form-data"
            class="flex flex-col gap-y-1">
            @csrf
            <label for="nama" class="font-bold">Nama Barang</label>
            <input type="text" name="nama_barang" class="p-1 border border-black" placeholder="Nama Barang" />
            @error('nama_barang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="merek" class="font-bold">Merek</label>
            <input type="text" name="merek" class="p-1 border border-black" placeholder="Merek" />
            @error('merek')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="supplier" class="font-bold">Supplier</label>
            <select name="supplier_id" id="supplier" class="p-1 border border-black">
                <option value="">-pilih supplier-</option>
                @foreach ($supplier as $s)
                    <option value="{{ $s->id }}">{{ $s->nama_perusahaan }}</option>
                @endforeach
            </select>
            @error('supplier_id')
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

            <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                Tambah Barang Baru
            </button>
        </form>
    </div>

</x-layoutAdmin>
