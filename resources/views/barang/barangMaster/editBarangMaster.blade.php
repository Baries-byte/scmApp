<x-layoutAdmin>
    <x-title>
        Ubah Data Barang Master {{ $barang->nama_barang }}
    </x-title>

    <div class="m-5">
        <form method="POST" action="{{ route('updateBarangMaster', ['barang' => $barang->id]) }}" class="flex flex-col gap-y-1"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="nama" class="font-bold">Nama Barang</label>
            <input type="text" name="nama_barang" class="p-1 border border-black" placeholder="Nama Barang"
                value="{{ $barang->nama_barang }}" />
            @error('nama_barang')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="merek" class="font-bold">Merek</label>
            <input type="text" name="merek" class="p-1 border border-black" placeholder="Merek"
                value="{{ $barang->merek }}" />
            @error('merek')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="supplier" class="font-bold">Supplier</label>
            <select name="supplier_id" id="supplier" class="p-1 border border-black">
                <option value="{{ $barang->supplier->id }}">{{ $barang->supplier->nama_perusahaan }}</option>
                @foreach ($supplier as $s)
                    <option value="{{ $s->id }}">{{ $s->nama_perusahaan }}</option>
                @endforeach
            </select>
            @error('supplier_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="kategori" class="font-bold">Kategori</label>
            <select name="kategori_id" id="kategori" class="p-1 border border-black">
                <option value="{{ $barang->kategori->id }}">{{ $barang->kategori->kategori }}</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id }}">{{ $k->kategori }}</option>
                @endforeach
            </select>
            @error('kategori_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                Ubah Data Barang Master
            </button>
        </form>
    </div>
</x-layoutAdmin>
